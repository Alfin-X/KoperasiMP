<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.schedules.index', [
            'schedules' => collect([]), // Placeholder data
            'title' => 'Jadwal & Absensi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.schedules.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.schedules.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Display attendance overview
     */
    public function attendance()
    {
        return view('admin.attendance.index', [
            'attendances' => collect([]), // Placeholder data
            'title' => 'Absensi'
        ]);
    }

    /**
     * Display attendance detail for specific schedule
     */
    public function attendanceDetail($schedule)
    {
        return view('admin.attendance.detail', [
            'schedule' => $schedule,
            'attendances' => collect([]), // Placeholder data
        ]);
    }
}
