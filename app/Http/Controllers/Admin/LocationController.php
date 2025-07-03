<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::withCount(['users', 'members'])->paginate(10);
        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:locations',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        Location::create($request->all());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        $location->load(['users', 'members.currentLevel']);
        return view('admin.locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:locations,code,' . $location->id,
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean',
        ]);

        $location->update($request->all());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        if ($location->users()->count() > 0 || $location->members()->count() > 0) {
            return redirect()->route('admin.locations.index')
                ->with('error', 'Lokasi tidak dapat dihapus karena masih memiliki user atau anggota.');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }
}
