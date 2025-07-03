<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules.
     */
    public function index()
    {
        $schedules = Schedule::with(['location', 'instructor', 'attendances'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->paginate(20);

        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        $locations = Location::where('is_active', true)->get();
        $instructors = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['admin', 'pelatih']);
        })->where('is_active', true)->get();

        return view('admin.schedules.create', compact('locations', 'instructors'));
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'instructor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'activity_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        Schedule::create([
            'location_id' => $request->location_id,
            'instructor_id' => $request->instructor_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'activity_type' => $request->activity_type,
            'description' => $request->description,
            'max_participants' => $request->max_participants,
            'is_active' => true,
        ]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal latihan berhasil dibuat.');
    }

    /**
     * Display the specified schedule.
     */
    public function show(Schedule $schedule)
    {
        $schedule->load(['location', 'instructor', 'attendances.member.user']);
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(Schedule $schedule)
    {
        $locations = Location::where('is_active', true)->get();
        $instructors = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['admin', 'pelatih']);
        })->where('is_active', true)->get();

        return view('admin.schedules.edit', compact('schedule', 'locations', 'instructors'));
    }

    /**
     * Update the specified schedule.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'instructor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'activity_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $schedule->update([
            'location_id' => $request->location_id,
            'instructor_id' => $request->instructor_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'activity_type' => $request->activity_type,
            'description' => $request->description,
            'max_participants' => $request->max_participants,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal latihan berhasil diperbarui.');
    }

    /**
     * Remove the specified schedule.
     */
    public function destroy(Schedule $schedule)
    {
        // Check if schedule has attendances
        if ($schedule->attendances()->exists()) {
            return redirect()->route('admin.schedules.index')
                ->with('error', 'Jadwal tidak dapat dihapus karena sudah memiliki data absensi.');
        }

        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal latihan berhasil dihapus.');
    }

    /**
     * Show attendance form for a schedule.
     */
    public function attendanceForm(Schedule $schedule)
    {
        $schedule->load(['location', 'instructor', 'attendances.member.user']);
        
        // Get all active members for this location
        $members = \App\Models\Member::with('user')
            ->whereHas('user', function($q) use ($schedule) {
                $q->where('location_id', $schedule->location_id)
                  ->where('is_active', true);
            })
            ->get();

        return view('admin.schedules.attendance-form', compact('schedule', 'members'));
    }

    /**
     * Generate recurring schedules.
     */
    public function generateRecurring(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'instructor_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'days_of_week' => 'required|array|min:1',
            'days_of_week.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'activity_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $daysOfWeek = $request->days_of_week;

        $createdCount = 0;
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dayName = strtolower($currentDate->format('l'));
            
            if (in_array($dayName, $daysOfWeek)) {
                // Check if schedule already exists for this date
                $existingSchedule = Schedule::where('location_id', $request->location_id)
                    ->where('instructor_id', $request->instructor_id)
                    ->where('date', $currentDate->format('Y-m-d'))
                    ->where('start_time', $request->start_time)
                    ->first();

                if (!$existingSchedule) {
                    Schedule::create([
                        'location_id' => $request->location_id,
                        'instructor_id' => $request->instructor_id,
                        'date' => $currentDate->format('Y-m-d'),
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'activity_type' => $request->activity_type,
                        'description' => $request->description,
                        'max_participants' => $request->max_participants,
                        'is_active' => true,
                    ]);
                    $createdCount++;
                }
            }
            
            $currentDate->addDay();
        }

        return redirect()->route('admin.schedules.index')
            ->with('success', "Berhasil membuat {$createdCount} jadwal latihan.");
    }
}
