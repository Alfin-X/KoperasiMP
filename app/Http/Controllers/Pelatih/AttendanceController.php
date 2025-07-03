<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display attendance dashboard for trainer's location.
     */
    public function index()
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        // Get member IDs from trainer's location
        $memberIds = Member::whereHas('user', function($q) use ($locationId) {
            $q->where('location_id', $locationId)->where('is_active', true);
        })->pluck('id');

        $stats = [
            'total_schedules' => Schedule::where('location_id', $locationId)->count(),
            'today_schedules' => Schedule::where('location_id', $locationId)
                ->whereDate('date', today())
                ->count(),
            'total_attendances' => Attendance::whereIn('member_id', $memberIds)
                ->where('status', 'present')
                ->count(),
            'today_attendances' => Attendance::whereIn('member_id', $memberIds)
                ->whereDate('date', today())
                ->where('status', 'present')
                ->count(),
        ];

        $todaySchedules = Schedule::with(['location', 'instructor', 'attendances.member.user'])
            ->where('location_id', $locationId)
            ->whereDate('date', today())
            ->orderBy('start_time')
            ->get();

        return view('pelatih.attendance.index', compact('stats', 'todaySchedules'));
    }

    /**
     * Display attendances for trainer's location.
     */
    public function attendances()
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        $attendances = Attendance::with(['member.user', 'location', 'schedule', 'recordedBy'])
            ->where('location_id', $locationId)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(20);

        return view('pelatih.attendance.attendances', compact('attendances'));
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create()
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        $schedules = Schedule::with(['location', 'instructor'])
            ->where('location_id', $locationId)
            ->whereDate('date', '>=', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $members = Member::with('user')->whereHas('user', function($q) use ($locationId) {
            $q->where('location_id', $locationId)->where('is_active', true);
        })->get();

        return view('pelatih.attendance.create', compact('schedules', 'members'));
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

        $user = auth()->user();
        $schedule = Schedule::find($request->schedule_id);

        // Verify schedule belongs to trainer's location
        if ($schedule->location_id !== $user->location_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk jadwal ini.');
        }

        // Verify member belongs to trainer's location
        $member = Member::find($request->member_id);
        if ($member->user->location_id !== $user->location_id) {
            return redirect()->back()->with('error', 'Anggota tidak terdaftar di lokasi Anda.');
        }

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

        return redirect()->route('pelatih.attendance.attendances')
            ->with('success', 'Absensi berhasil dicatat.');
    }

    /**
     * Show the form for editing the specified attendance.
     */
    public function edit(Attendance $attendance)
    {
        $user = auth()->user();

        // Verify attendance belongs to trainer's location
        if ($attendance->location_id !== $user->location_id) {
            return redirect()->route('pelatih.attendance.attendances')
                ->with('error', 'Anda tidak memiliki akses untuk data absensi ini.');
        }

        $schedules = Schedule::with(['location', 'instructor'])
            ->where('location_id', $user->location_id)
            ->whereDate('date', '>=', today()->subDays(7))
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $members = Member::with('user')->whereHas('user', function($q) use ($user) {
            $q->where('location_id', $user->location_id)->where('is_active', true);
        })->get();

        return view('pelatih.attendance.edit', compact('attendance', 'schedules', 'members'));
    }

    /**
     * Update the specified attendance.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $user = auth()->user();

        // Verify attendance belongs to trainer's location
        if ($attendance->location_id !== $user->location_id) {
            return redirect()->route('pelatih.attendance.attendances')
                ->with('error', 'Anda tidak memiliki akses untuk data absensi ini.');
        }

        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'member_id' => 'required|exists:members,id',
            'status' => 'required|in:present,absent,late,excused',
            'notes' => 'nullable|string|max:255',
        ]);

        $schedule = Schedule::find($request->schedule_id);

        // Verify schedule belongs to trainer's location
        if ($schedule->location_id !== $user->location_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk jadwal ini.');
        }

        $attendance->update([
            'member_id' => $request->member_id,
            'location_id' => $schedule->location_id,
            'schedule_id' => $request->schedule_id,
            'date' => $schedule->date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('pelatih.attendance.attendances')
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    /**
     * Show attendance reports for trainer's location.
     */
    public function reports()
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        $monthlyStats = Attendance::selectRaw('
            YEAR(date) as year,
            MONTH(date) as month,
            COUNT(*) as total_attendances,
            SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count,
            SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_count,
            SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count,
            SUM(CASE WHEN status = "excused" THEN 1 ELSE 0 END) as excused_count
        ')
        ->where('location_id', $locationId)
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        return view('pelatih.attendance.reports', compact('monthlyStats'));
    }

    /**
     * Show member attendance history for trainer's location.
     */
    public function memberHistory(Member $member)
    {
        $user = auth()->user();

        // Verify member belongs to trainer's location
        if ($member->user->location_id !== $user->location_id) {
            return redirect()->route('pelatih.attendance.attendances')
                ->with('error', 'Anda tidak memiliki akses untuk data anggota ini.');
        }

        $attendanceHistory = $member->attendances()
            ->with(['location', 'schedule', 'recordedBy'])
            ->where('location_id', $user->location_id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        $stats = [
            'total_attendances' => $member->attendances()->where('location_id', $user->location_id)->count(),
            'present_count' => $member->attendances()->where('location_id', $user->location_id)->where('status', 'present')->count(),
            'late_count' => $member->attendances()->where('location_id', $user->location_id)->where('status', 'late')->count(),
            'absent_count' => $member->attendances()->where('location_id', $user->location_id)->where('status', 'absent')->count(),
            'excused_count' => $member->attendances()->where('location_id', $user->location_id)->where('status', 'excused')->count(),
        ];

        return view('pelatih.attendance.member-history', compact('member', 'attendanceHistory', 'stats'));
    }

    /**
     * Show attendance form for a schedule.
     */
    public function attendanceForm(Schedule $schedule)
    {
        $user = auth()->user();

        // Verify schedule belongs to trainer's location
        if ($schedule->location_id !== $user->location_id) {
            return redirect()->route('pelatih.attendance.index')
                ->with('error', 'Anda tidak memiliki akses untuk jadwal ini.');
        }

        $schedule->load(['location', 'instructor', 'attendances.member.user']);
        
        // Get all active members for this location
        $members = Member::with('user')
            ->whereHas('user', function($q) use ($schedule) {
                $q->where('location_id', $schedule->location_id)
                  ->where('is_active', true);
            })
            ->get();

        return view('pelatih.attendance.attendance-form', compact('schedule', 'members'));
    }

    /**
     * Bulk attendance recording for a schedule.
     */
    public function bulkAttendance(Request $request, Schedule $schedule)
    {
        $user = auth()->user();

        // Verify schedule belongs to trainer's location
        if ($schedule->location_id !== $user->location_id) {
            return redirect()->route('pelatih.attendance.index')
                ->with('error', 'Anda tidak memiliki akses untuk jadwal ini.');
        }

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

        return redirect()->route('pelatih.attendance.index')
            ->with('success', 'Absensi massal berhasil dicatat.');
    }
}
