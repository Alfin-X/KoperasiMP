<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kolat;
use App\Models\Schedule;
use App\Models\SppBill;

class DashboardController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        $totalAnggota = User::where('role_id', function($query) {
            $query->select('id')->from('roles')->where('name', 'anggota');
        })->where('is_active', true)->count();

        $totalPelatih = User::where('role_id', function($query) {
            $query->select('id')->from('roles')->where('name', 'pelatih');
        })->where('is_active', true)->count();

        $totalKolat = Kolat::where('is_active', true)->count();

        $pendingSppPayments = SppBill::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalAnggota',
            'totalPelatih',
            'totalKolat',
            'pendingSppPayments'
        ));
    }

    /**
     * Pelatih Dashboard
     */
    public function pelatihDashboard()
    {
        $user = auth()->user();
        $kolat = $user->kolat;

        $anggotaKolat = $kolat ? $kolat->activeMembers()->count() : 0;
        $jadwalHariIni = Schedule::where('kolat_id', $kolat?->id)
            ->whereDate('date', today())
            ->count();

        return view('pelatih.dashboard', compact('anggotaKolat', 'jadwalHariIni', 'kolat'));
    }

    /**
     * Anggota Dashboard
     */
    public function anggotaDashboard()
    {
        $user = auth()->user();
        $kolat = $user->kolat;

        $sppBelumBayar = SppBill::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $jadwalTerdekat = Schedule::where('kolat_id', $kolat?->id)
            ->where('date', '>=', today())
            ->orderBy('date')
            ->first();

        return view('anggota.dashboard', compact('sppBelumBayar', 'jadwalTerdekat', 'kolat'));
    }
}
