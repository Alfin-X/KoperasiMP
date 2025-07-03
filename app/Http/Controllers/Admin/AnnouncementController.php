<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Location;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::with(['author', 'location'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::where('is_active', true)->get();
        return view('admin.announcements.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,urgent,event,maintenance',
            'target_audience' => 'required|in:all,members,staff,location_specific',
            'location_id' => 'nullable|exists:locations,id',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'target_audience' => $request->target_audience,
            'location_id' => $request->target_audience === 'location_specific' ? $request->location_id : null,
            'author_id' => auth()->id(),
            'is_active' => $request->has('is_active'),
            'published_at' => $request->published_at ?? now(),
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        $announcement->load(['author', 'location']);
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        $locations = Location::where('is_active', true)->get();
        return view('admin.announcements.edit', compact('announcement', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,urgent,event,maintenance',
            'target_audience' => 'required|in:all,members,staff,location_specific',
            'location_id' => 'nullable|exists:locations,id',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'target_audience' => $request->target_audience,
            'location_id' => $request->target_audience === 'location_specific' ? $request->location_id : null,
            'is_active' => $request->has('is_active'),
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
