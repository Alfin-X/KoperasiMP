<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\CooperativeSaving;
use Illuminate\Http\Request;

class CooperativeController extends Controller
{
    /**
     * Display member's cooperative savings.
     */
    public function index()
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        $savings = $member->cooperativeSavings()
            ->with('processedBy')
            ->orderBy('transaction_date', 'desc')
            ->paginate(20);

        $balances = [
            'pokok' => $member->getCooperativeSavingsByCategory('pokok'),
            'wajib' => $member->getCooperativeSavingsByCategory('wajib'),
            'sukarela' => $member->getCooperativeSavingsByCategory('sukarela'),
            'total' => $member->total_cooperative_savings,
        ];

        return view('anggota.cooperative.index', compact('savings', 'balances', 'member'));
    }

    /**
     * Show payment form for cooperative savings.
     */
    public function showPaymentForm()
    {
        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        return view('anggota.cooperative.payment', compact('member'));
    }

    /**
     * Process payment for cooperative savings.
     * Note: This is a simulation - in real implementation, 
     * this would integrate with payment gateway.
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'category' => 'required|in:pokok,wajib,sukarela',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:transfer,cash',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $member = auth()->user()->member;
        
        if (!$member) {
            return redirect()->route('anggota.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        // Handle payment proof upload
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        // For now, we'll create a pending transaction that needs admin approval
        // In real implementation, this would be handled by payment gateway
        
        $description = 'Pembayaran ' . ucfirst($request->category) . ' via ' . $request->payment_method;
        if ($paymentProofPath) {
            $description .= ' (Bukti: ' . $paymentProofPath . ')';
        }

        // Create a note for admin to process
        session()->flash('payment_pending', [
            'member_id' => $member->id,
            'category' => $request->category,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_proof' => $paymentProofPath,
            'description' => $description,
        ]);

        return redirect()->route('anggota.cooperative.index')
            ->with('success', 'Pembayaran berhasil dikirim. Menunggu konfirmasi admin.');
    }
}
