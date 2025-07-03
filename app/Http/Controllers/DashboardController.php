<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\Location;
use App\Models\Attendance;
use App\Models\SppPayment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function admin()
    {
        $stats = [
            'total_members' => Member::count(),
            'total_locations' => Location::where('is_active', true)->count(),
            'total_instructors' => User::whereHas('role', function($q) {
                $q->where('name', 'pelatih');
            })->count(),
            'monthly_revenue' => SppPayment::where('status', 'paid')
                ->whereMonth('paid_date', Carbon::now()->month)
                ->sum('paid_amount'),
            'pending_spp_notifications' => SppPayment::where('status', 'pending')
                ->where('due_date', '<', Carbon::now())
                ->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Pelatih Dashboard
     */
    public function pelatih()
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        $stats = [
            'location_members' => Member::where('location_id', $locationId)->count(),
            'today_attendance' => Attendance::where('location_id', $locationId)
                ->where('attendance_date', Carbon::today())
                ->count(),
            'pending_promotions' => 0, // Will implement later
        ];

        return view('pelatih.dashboard', compact('stats'));
    }

    /**
     * Anggota Dashboard
     */
    public function anggota()
    {
        $user = auth()->user();
        $member = $user->member;

        if (!$member) {
            return redirect()->route('login')->with('error', 'Data anggota tidak ditemukan.');
        }

        $stats = [
            'current_level' => $member->currentLevel->name ?? 'Belum ditentukan',
            'monthly_attendance' => Attendance::where('member_id', $member->id)
                ->whereMonth('attendance_date', Carbon::now()->month)
                ->where('status', 'present')
                ->count(),
            'outstanding_spp' => SppPayment::where('member_id', $member->id)
                ->where('status', 'pending')
                ->sum('total_amount'),
        ];

        return view('anggota.dashboard', compact('stats', 'member'));
    }
}
