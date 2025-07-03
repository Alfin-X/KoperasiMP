<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display member's attendance history and upcoming schedules.
     */
    public function index()
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        $attendanceHistory = $member->attendances()
            ->with(['location', 'schedule', 'recordedBy'])
            ->orderBy('date', 'desc')
            ->paginate(20);

        $stats = [
            'total_attendances' => $member->attendances()->count(),
            'present_count' => $member->attendances()->where('status', 'present')->count(),
            'late_count' => $member->attendances()->where('status', 'late')->count(),
            'absent_count' => $member->attendances()->where('status', 'absent')->count(),
            'excused_count' => $member->attendances()->where('status', 'excused')->count(),
        ];

        // Calculate attendance percentage
        $totalAttendances = $stats['total_attendances'];
        $presentAttendances = $stats['present_count'] + $stats['late_count']; // Count late as present
        $attendancePercentage = $totalAttendances > 0 ? round(($presentAttendances / $totalAttendances) * 100, 2) : 0;

        return view('anggota.attendance.index', compact('attendanceHistory', 'stats', 'attendancePercentage', 'member'));
    }

    /**
     * Display upcoming schedules for member's location.
     */
    public function schedules()
    {
        $user = auth()->user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        $upcomingSchedules = Schedule::with(['location', 'instructor', 'attendances' => function($q) use ($member) {
            $q->where('member_id', $member->id);
        }])
        ->where('location_id', $user->location_id)
        ->where('date', '>=', today())
        ->where('is_active', true)
        ->orderBy('date')
        ->orderBy('start_time')
        ->paginate(20);

        return view('anggota.attendance.schedules', compact('upcomingSchedules', 'member'));
    }

    /**
     * Show detailed view of a specific schedule.
     */
    public function showSchedule(Schedule $schedule)
    {
        $user = auth()->user();
        $member = $user->member;
        
        if (!$member) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        // Verify schedule belongs to member's location
        if ($schedule->location_id !== $user->location_id) {
            return redirect()->route('anggota.attendance.schedules')
                ->with('error', 'Anda tidak memiliki akses untuk melihat jadwal ini.');
        }

        $schedule->load(['location', 'instructor']);
        
        // Get member's attendance for this schedule
        $memberAttendance = $schedule->attendances()
            ->where('member_id', $member->id)
            ->first();

        // Get total participants for this schedule
        $totalParticipants = $schedule->attendances()
            ->where('status', '!=', 'absent')
            ->count();

        return view('anggota.attendance.schedule-detail', compact('schedule', 'memberAttendance', 'totalParticipants', 'member'));
    }

    /**
     * Show monthly attendance summary.
     */
    public function monthlySummary(Request $request)
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $monthlyAttendances = $member->attendances()
            ->with(['location', 'schedule', 'recordedBy'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();

        $monthlyStats = [
            'total_attendances' => $monthlyAttendances->count(),
            'present_count' => $monthlyAttendances->where('status', 'present')->count(),
            'late_count' => $monthlyAttendances->where('status', 'late')->count(),
            'absent_count' => $monthlyAttendances->where('status', 'absent')->count(),
            'excused_count' => $monthlyAttendances->where('status', 'excused')->count(),
        ];

        // Calculate monthly attendance percentage
        $totalMonthlyAttendances = $monthlyStats['total_attendances'];
        $presentMonthlyAttendances = $monthlyStats['present_count'] + $monthlyStats['late_count'];
        $monthlyAttendancePercentage = $totalMonthlyAttendances > 0 ? 
            round(($presentMonthlyAttendances / $totalMonthlyAttendances) * 100, 2) : 0;

        return view('anggota.attendance.monthly-summary', compact(
            'monthlyAttendances', 
            'monthlyStats', 
            'monthlyAttendancePercentage', 
            'year', 
            'month', 
            'member'
        ));
    }

    /**
     * Show attendance certificate (if eligible).
     */
    public function certificate()
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        // Calculate overall attendance statistics
        $totalAttendances = $member->attendances()->count();
        $presentAttendances = $member->attendances()
            ->whereIn('status', ['present', 'late'])
            ->count();
        
        $attendancePercentage = $totalAttendances > 0 ? 
            round(($presentAttendances / $totalAttendances) * 100, 2) : 0;

        // Check if member is eligible for certificate (e.g., 80% attendance)
        $isEligible = $attendancePercentage >= 80 && $totalAttendances >= 10;

        if (!$isEligible) {
            return redirect()->route('anggota.attendance.index')
                ->with('error', 'Anda belum memenuhi syarat untuk mendapatkan sertifikat kehadiran. Minimal 80% kehadiran dengan 10 kali latihan.');
        }

        // In real implementation, this would generate a PDF certificate
        return view('anggota.attendance.certificate', compact(
            'member', 
            'totalAttendances', 
            'presentAttendances', 
            'attendancePercentage'
        ));
    }
}
