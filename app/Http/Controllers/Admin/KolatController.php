<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KolatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.kolats.index', [
            'kolats' => collect([]), // Placeholder data
            'title' => 'Manajemen Kolat'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kolats.create', [
            'title' => 'Tambah Kolat Baru'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data (akan diimplementasi dengan model)
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:kolats,code',
            'address' => 'required|string'
        ]);

        return redirect()->route('admin.kolats.index')
            ->with('success', 'Kolat berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.kolats.show', [
            'kolat' => (object)[
                'id' => $id,
                'name' => 'Kolat Contoh',
                'code' => 'KOLAT-001'
            ],
            'title' => 'Detail Kolat'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.kolats.edit', [
            'kolat' => (object)[
                'id' => $id,
                'name' => 'Kolat Contoh',
                'code' => 'KOLAT-001'
            ],
            'title' => 'Edit Kolat'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('admin.kolats.index')
            ->with('success', 'Kolat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('admin.kolats.index')
            ->with('success', 'Kolat berhasil dihapus.');
    }
}
