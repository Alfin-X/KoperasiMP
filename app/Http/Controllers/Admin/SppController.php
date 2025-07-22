<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.spp.index', [
            'bills' => collect([]), // Placeholder data
            'payments' => collect([]), // Placeholder data
            'title' => 'Manajemen SPP'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.spp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.spp.index')
            ->with('success', 'SPP berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.spp.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.spp.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('admin.spp.index')
            ->with('success', 'SPP berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('admin.spp.index')
            ->with('success', 'SPP berhasil dihapus.');
    }

    /**
     * Generate SPP bills for all active members
     */
    public function generateBills(Request $request)
    {
        return redirect()->route('admin.spp.index')
            ->with('success', 'Tagihan SPP berhasil digenerate untuk semua anggota aktif.');
    }

    /**
     * Verify SPP payment
     */
    public function verifyPayment(Request $request, $payment)
    {
        return redirect()->route('admin.spp.index')
            ->with('success', 'Pembayaran SPP berhasil diverifikasi.');
    }
}
