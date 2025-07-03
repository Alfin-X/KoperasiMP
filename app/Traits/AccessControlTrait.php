<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait AccessControlTrait
{
    /**
     * Check if the current user can access data from a specific location.
     */
    protected function canAccessLocation($locationId): bool
    {
        $user = auth()->user();
        
        // Admin can access all locations
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Pelatih can only access their assigned location
        if ($user->hasRole('pelatih')) {
            return $user->location_id === $locationId;
        }
        
        // Anggota can only access their own location
        if ($user->hasRole('anggota')) {
            return $user->location_id === $locationId;
        }
        
        return false;
    }
    
    /**
     * Check if the current user can access a specific member's data.
     */
    protected function canAccessMember($memberId): bool
    {
        $user = auth()->user();
        
        // Admin can access all members
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Pelatih can access members from their location
        if ($user->hasRole('pelatih')) {
            $member = \App\Models\Member::find($memberId);
            return $member && $member->user && $member->user->location_id === $user->location_id;
        }
        
        // Anggota can only access their own data
        if ($user->hasRole('anggota')) {
            return $user->member && $user->member->id === $memberId;
        }
        
        return false;
    }
    
    /**
     * Filter query based on user's access level.
     */
    protected function filterByAccess($query, $locationColumn = 'location_id', $memberColumn = null)
    {
        $user = auth()->user();
        
        // Admin can see all data
        if ($user->hasRole('admin')) {
            return $query;
        }
        
        // Pelatih can see data from their location
        if ($user->hasRole('pelatih')) {
            return $query->where($locationColumn, $user->location_id);
        }
        
        // Anggota can only see their own data
        if ($user->hasRole('anggota') && $memberColumn) {
            return $query->where($memberColumn, $user->member->id ?? 0);
        }
        
        // If no specific member column for anggota, filter by location
        if ($user->hasRole('anggota')) {
            return $query->where($locationColumn, $user->location_id);
        }
        
        return $query->whereRaw('1 = 0'); // Return empty result for unknown roles
    }
    
    /**
     * Get accessible locations for the current user.
     */
    protected function getAccessibleLocations()
    {
        $user = auth()->user();
        
        // Admin can access all locations
        if ($user->hasRole('admin')) {
            return \App\Models\Location::where('is_active', true)->get();
        }
        
        // Pelatih and Anggota can only access their assigned location
        if ($user->hasRole(['pelatih', 'anggota'])) {
            return \App\Models\Location::where('id', $user->location_id)
                ->where('is_active', true)
                ->get();
        }
        
        return collect();
    }
    
    /**
     * Get accessible members for the current user.
     */
    protected function getAccessibleMembers()
    {
        $user = auth()->user();
        
        // Admin can access all members
        if ($user->hasRole('admin')) {
            return \App\Models\Member::with('user')
                ->whereHas('user', function($q) {
                    $q->where('is_active', true);
                })
                ->get();
        }
        
        // Pelatih can access members from their location
        if ($user->hasRole('pelatih')) {
            return \App\Models\Member::with('user')
                ->whereHas('user', function($q) use ($user) {
                    $q->where('location_id', $user->location_id)
                      ->where('is_active', true);
                })
                ->get();
        }
        
        // Anggota can only access their own member record
        if ($user->hasRole('anggota')) {
            return collect([$user->member])->filter();
        }
        
        return collect();
    }
    
    /**
     * Validate access to a model instance.
     */
    protected function validateAccess($model, $errorMessage = 'Anda tidak memiliki akses untuk data ini.')
    {
        $user = auth()->user();
        
        // Admin has access to everything
        if ($user->hasRole('admin')) {
            return true;
        }
        
        $modelClass = get_class($model);
        
        // Check access based on model type
        switch ($modelClass) {
            case 'App\Models\Member':
                if (!$this->canAccessMember($model->id)) {
                    abort(403, $errorMessage);
                }
                break;
                
            case 'App\Models\Schedule':
            case 'App\Models\Attendance':
            case 'App\Models\CooperativeTransaction':
                if (!$this->canAccessLocation($model->location_id)) {
                    abort(403, $errorMessage);
                }
                break;
                
            case 'App\Models\SppPayment':
            case 'App\Models\CooperativeLoan':
            case 'App\Models\CooperativeSaving':
                if (!$this->canAccessMember($model->member_id)) {
                    abort(403, $errorMessage);
                }
                break;
        }
        
        return true;
    }
    
    /**
     * Get dashboard statistics filtered by user access.
     */
    protected function getDashboardStats()
    {
        $user = auth()->user();
        $stats = [];
        
        if ($user->hasRole('admin')) {
            $stats = [
                'total_members' => \App\Models\Member::count(),
                'total_locations' => \App\Models\Location::where('is_active', true)->count(),
                'total_schedules' => \App\Models\Schedule::count(),
                'total_attendances' => \App\Models\Attendance::where('status', 'present')->count(),
            ];
        } elseif ($user->hasRole('pelatih')) {
            $memberIds = \App\Models\Member::whereHas('user', function($q) use ($user) {
                $q->where('location_id', $user->location_id);
            })->pluck('id');
            
            $stats = [
                'location_members' => $memberIds->count(),
                'location_schedules' => \App\Models\Schedule::where('location_id', $user->location_id)->count(),
                'location_attendances' => \App\Models\Attendance::whereIn('member_id', $memberIds)
                    ->where('status', 'present')->count(),
                'today_schedules' => \App\Models\Schedule::where('location_id', $user->location_id)
                    ->whereDate('date', today())->count(),
            ];
        } elseif ($user->hasRole('anggota')) {
            $member = $user->member;
            if ($member) {
                $stats = [
                    'my_attendances' => $member->attendances()->count(),
                    'present_count' => $member->attendances()->where('status', 'present')->count(),
                    'upcoming_schedules' => \App\Models\Schedule::where('location_id', $user->location_id)
                        ->where('date', '>=', today())->count(),
                    'pending_spp' => $member->sppPayments()->where('status', 'pending')->count(),
                ];
            }
        }
        
        return $stats;
    }
}
