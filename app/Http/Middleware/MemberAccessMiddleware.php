<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberAccessMiddleware
{
    /**
     * Handle an incoming request.
     * This middleware ensures that Anggota can only access their own data.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Only apply member restriction to Anggota role
        if ($user->hasRole('anggota')) {
            // Check if user has a member record
            if (!$user->member) {
                abort(403, 'Data anggota tidak ditemukan. Hubungi administrator.');
            }

            // For route model binding, check if the model belongs to the member
            $routeParameters = $request->route()->parameters();
            
            foreach ($routeParameters as $parameter) {
                if (is_object($parameter)) {
                    $parameterClass = get_class($parameter);
                    
                    // Check SppPayment access
                    if ($parameterClass === 'App\Models\SppPayment') {
                        if ($parameter->member_id !== $user->member->id) {
                            abort(403, 'Anda tidak memiliki akses untuk data SPP ini.');
                        }
                    }
                    
                    // Check Attendance access
                    if ($parameterClass === 'App\Models\Attendance') {
                        if ($parameter->member_id !== $user->member->id) {
                            abort(403, 'Anda tidak memiliki akses untuk data absensi ini.');
                        }
                    }
                    
                    // Check Schedule access (must be from member's location)
                    if ($parameterClass === 'App\Models\Schedule') {
                        if ($parameter->location_id !== $user->location_id) {
                            abort(403, 'Anda tidak memiliki akses untuk jadwal dari lokasi lain.');
                        }
                    }
                    
                    // Check CooperativeTransaction access
                    if ($parameterClass === 'App\Models\CooperativeTransaction') {
                        if ($parameter->member_id !== $user->member->id) {
                            abort(403, 'Anda tidak memiliki akses untuk transaksi koperasi ini.');
                        }
                    }
                    
                    // Check CooperativeLoan access
                    if ($parameterClass === 'App\Models\CooperativeLoan') {
                        if ($parameter->member_id !== $user->member->id) {
                            abort(403, 'Anda tidak memiliki akses untuk data pinjaman ini.');
                        }
                    }
                    
                    // Check CooperativeSaving access
                    if ($parameterClass === 'App\Models\CooperativeSaving') {
                        if ($parameter->member_id !== $user->member->id) {
                            abort(403, 'Anda tidak memiliki akses untuk data simpanan ini.');
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}
