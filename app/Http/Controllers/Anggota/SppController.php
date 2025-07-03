<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\SppPayment;
use Illuminate\Http\Request;

class SppController extends Controller
{
    /**
     * Display member's SPP status and history.
     */
    public function index()
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        $sppPayments = $member->sppPayments()
            ->with('processedBy')
            ->orderBy('due_date', 'desc')
            ->paginate(20);

        $stats = [
            'total_bills' => $member->sppPayments()->count(),
            'paid_bills' => $member->sppPayments()->where('status', 'paid')->count(),
            'pending_bills' => $member->sppPayments()->where('status', 'pending')->count(),
            'overdue_bills' => $member->sppPayments()
                ->where('due_date', '<', now())
                ->where('status', 'pending')
                ->count(),
        ];

        $currentMonthSpp = $member->sppPayments()
            ->whereMonth('due_date', now()->month)
            ->whereYear('due_date', now()->year)
            ->first();

        return view('anggota.spp.index', compact('sppPayments', 'stats', 'currentMonthSpp', 'member'));
    }

    /**
     * Show payment form for SPP.
     */
    public function showPaymentForm(SppPayment $spp)
    {
        $member = auth()->user()->member;
        
        if (!$member || $spp->member_id !== $member->id) {
            return redirect()->route('anggota.spp.index')->with('error', 'Anda tidak memiliki akses untuk membayar tagihan ini.');
        }

        if ($spp->status === 'paid') {
            return redirect()->route('anggota.spp.index')->with('info', 'Tagihan ini sudah lunas.');
        }

        return view('anggota.spp.payment', compact('spp', 'member'));
    }

    /**
     * Process payment for SPP.
     * Note: This is a simulation - in real implementation, 
     * this would integrate with payment gateway.
     */
    public function processPayment(Request $request, SppPayment $spp)
    {
        $member = auth()->user()->member;
        
        if (!$member || $spp->member_id !== $member->id) {
            return redirect()->route('anggota.spp.index')->with('error', 'Anda tidak memiliki akses untuk membayar tagihan ini.');
        }

        if ($spp->status === 'paid') {
            return redirect()->route('anggota.spp.index')->with('info', 'Tagihan ini sudah lunas.');
        }

        $request->validate([
            'payment_amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:transfer,savings_deduction',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $remainingAmount = $spp->amount - ($spp->paid_amount ?? 0);
        if ($request->payment_amount > $remainingAmount) {
            return redirect()->back()->with('error', 'Jumlah pembayaran melebihi sisa tagihan.');
        }

        // Handle payment proof upload
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('spp-payment-proofs', 'public');
        }

        // For now, we'll create a pending payment that needs admin/trainer approval
        // In real implementation, this would be handled by payment gateway
        
        $paymentNotes = 'Pembayaran via ' . $request->payment_method;
        if ($paymentProofPath) {
            $paymentNotes .= ' (Bukti: ' . $paymentProofPath . ')';
        }

        // Create a note for admin/trainer to process
        session()->flash('payment_pending', [
            'spp_id' => $spp->id,
            'payment_amount' => $request->payment_amount,
            'payment_method' => $request->payment_method,
            'payment_proof' => $paymentProofPath,
            'payment_notes' => $paymentNotes,
        ]);

        return redirect()->route('anggota.spp.index')
            ->with('success', 'Pembayaran berhasil dikirim. Menunggu konfirmasi admin/pelatih.');
    }

    /**
     * Download SPP payment receipt.
     */
    public function downloadReceipt(SppPayment $spp)
    {
        $member = auth()->user()->member;
        
        if (!$member || $spp->member_id !== $member->id) {
            return redirect()->route('anggota.spp.index')->with('error', 'Anda tidak memiliki akses untuk mengunduh kwitansi ini.');
        }

        if ($spp->status !== 'paid') {
            return redirect()->route('anggota.spp.index')->with('error', 'Kwitansi hanya tersedia untuk tagihan yang sudah lunas.');
        }

        // In real implementation, this would generate a PDF receipt
        // For now, we'll just redirect back with a message
        return redirect()->route('anggota.spp.index')
            ->with('info', 'Fitur unduh kwitansi akan segera tersedia.');
    }
}
