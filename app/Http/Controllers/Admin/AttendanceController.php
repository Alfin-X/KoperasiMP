<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Member;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display attendance dashboard.
     */
    public function index()
    {
        $stats = [
            'total_schedules' => Schedule::count(),
            'today_schedules' => Schedule::whereDate('date', today())->count(),
            'total_attendances' => Attendance::where('status', 'present')->count(),
            'today_attendances' => Attendance::whereDate('date', today())
                ->where('status', 'present')
                ->count(),
        ];

        $todaySchedules = Schedule::with(['location', 'instructor', 'attendances.member.user'])
            ->whereDate('date', today())
            ->orderBy('start_time')
            ->get();

        return view('admin.attendance.index', compact('stats', 'todaySchedules'));
    }

    /**
     * Display all attendances.
     */
    public function attendances()
    {
        $attendances = Attendance::with(['member.user', 'location', 'schedule', 'recordedBy'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(20);

        return view('admin.attendance.attendances', compact('attendances'));
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create()
    {
        $schedules = Schedule::with(['location', 'instructor'])
            ->whereDate('date', '>=', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $members = Member::with('user')->whereHas('user', function($q) {
            $q->where('is_active', true);
        })->get();

        return view('admin.attendance.create', compact('schedules', 'members'));
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'member_id' => 'required|exists:members,id',
            'status' => 'required|in:present,absent,late,excused',
            'notes' => 'nullable|string|max:255',
        ]);

        $schedule = Schedule::find($request->schedule_id);

        // Check if attendance already exists
        $existingAttendance = Attendance::where('member_id', $request->member_id)
            ->where('schedule_id', $request->schedule_id)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'Absensi untuk anggota ini pada jadwal tersebut sudah ada.');
        }

        Attendance::create([
            'member_id' => $request->member_id,
            'location_id' => $schedule->location_id,
            'schedule_id' => $request->schedule_id,
            'date' => $schedule->date,
            'time' => now()->format('H:i:s'),
            'status' => $request->status,
            'notes' => $request->notes,
            'recorded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.attendance.attendances')
            ->with('success', 'Absensi berhasil dicatat.');
    }

    /**
     * Show the form for editing the specified attendance.
     */
    public function edit(Attendance $attendance)
    {
        $schedules = Schedule::with(['location', 'instructor'])
            ->whereDate('date', '>=', today()->subDays(7))
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $members = Member::with('user')->whereHas('user', function($q) {
            $q->where('is_active', true);
        })->get();

        return view('admin.attendance.edit', compact('attendance', 'schedules', 'members'));
    }

    /**
     * Update the specified attendance.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'member_id' => 'required|exists:members,id',
            'status' => 'required|in:present,absent,late,excused',
            'notes' => 'nullable|string|max:255',
        ]);

        $schedule = Schedule::find($request->schedule_id);

        $attendance->update([
            'member_id' => $request->member_id,
            'location_id' => $schedule->location_id,
            'schedule_id' => $request->schedule_id,
            'date' => $schedule->date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.attendance.attendances')
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    /**
     * Remove the specified attendance.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('admin.attendance.attendances')
            ->with('success', 'Absensi berhasil dihapus.');
    }

    /**
     * Show attendance reports.
     */
    public function reports()
    {
        $monthlyStats = Attendance::selectRaw('
            YEAR(date) as year,
            MONTH(date) as month,
            COUNT(*) as total_attendances,
            SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count,
            SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_count,
            SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count,
            SUM(CASE WHEN status = "excused" THEN 1 ELSE 0 END) as excused_count
        ')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        return view('admin.attendance.reports', compact('monthlyStats'));
    }

    /**
     * Show member attendance history.
     */
    public function memberHistory(Member $member)
    {
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

        return view('admin.attendance.member-history', compact('member', 'attendanceHistory', 'stats'));
    }

    /**
     * Bulk attendance recording for a schedule.
     */
    public function bulkAttendance(Request $request, Schedule $schedule)
    {
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*.member_id' => 'required|exists:members,id',
            'attendances.*.status' => 'required|in:present,absent,late,excused',
            'attendances.*.notes' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $schedule) {
            foreach ($request->attendances as $attendanceData) {
                // Check if attendance already exists
                $existingAttendance = Attendance::where('member_id', $attendanceData['member_id'])
                    ->where('schedule_id', $schedule->id)
                    ->first();

                if (!$existingAttendance) {
                    Attendance::create([
                        'member_id' => $attendanceData['member_id'],
                        'location_id' => $schedule->location_id,
                        'schedule_id' => $schedule->id,
                        'date' => $schedule->date,
                        'time' => now()->format('H:i:s'),
                        'status' => $attendanceData['status'],
                        'notes' => $attendanceData['notes'] ?? null,
                        'recorded_by' => auth()->id(),
                    ]);
                }
            }
        });

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Absensi massal berhasil dicatat.');
    }
}
