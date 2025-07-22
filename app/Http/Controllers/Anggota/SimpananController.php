<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Savings;
use App\Models\SavingsTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $savings = $user->savings ?? new Savings(['user_id' => $user->id]);
        $transactions = $user->savingsTransactions()->latest()->take(5)->get();

        return view('anggota.simpanan.index', [
            'savings' => $savings,
            'transactions' => $transactions,
            'title' => 'Simpanan Saya'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('anggota.simpanan.create', [
            'title' => 'Tambah Simpanan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi dasar
        $rules = [
            'type' => 'required|in:simpanan_pokok,simpanan_wajib,simpanan_sukarela',
            'description' => 'nullable|string|max:500',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        // Validasi nominal berdasarkan jenis simpanan
        switch ($request->type) {
            case 'simpanan_pokok':
                $rules['amount'] = 'required|numeric|in:50000';
                break;
            case 'simpanan_wajib':
                $rules['amount'] = 'required|numeric|min:3000';
                break;
            case 'simpanan_sukarela':
                $rules['amount'] = 'required|numeric|min:1000';
                break;
            default:
                $rules['amount'] = 'required|numeric|min:1000';
        }

        $request->validate($rules, [
            'amount.in' => 'Simpanan pokok harus tepat Rp 50.000',
            'amount.min' => 'Nominal minimal untuk jenis simpanan ini adalah Rp :min'
        ]);

        // Cek apakah simpanan pokok sudah pernah dibayar
        if ($request->type === 'simpanan_pokok') {
            $existingSavings = $user->savings;
            if ($existingSavings && $existingSavings->simpanan_pokok_paid) {
                return redirect()->back()
                    ->withErrors(['type' => 'Simpanan pokok sudah pernah dibayar.']);
            }
        }

        // Simpan bukti transfer jika ada
        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $proofPath = $request->file('proof_image')->store('simpanan-proofs', 'public');
        }

        // Simpan transaksi simpanan
        SavingsTransaction::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'proof_image' => $proofPath,
            'status' => 'pending',
            'recorded_by' => $user->id, // Anggota yang mengajukan
        ]);

        return redirect()->route('anggota.simpanan.index')
            ->with('success', 'Transaksi simpanan berhasil diajukan. Menunggu verifikasi dari pelatih.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show savings balance
     */
    public function balance()
    {
        $user = Auth::user();
        $savings = $user->savings ?? new Savings([
            'user_id' => $user->id,
            'simpanan_pokok' => 0,
            'simpanan_wajib' => 0,
            'simpanan_sukarela' => 0,
            'total_balance' => 0,
            'simpanan_pokok_paid' => false
        ]);

        return view('anggota.simpanan.balance', [
            'title' => 'Saldo Simpanan',
            'savings' => $savings
        ]);
    }

    /**
     * Show savings transaction history
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $query = $user->savingsTransactions()->latest();

        // Filter berdasarkan jenis simpanan
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->paginate(10);

        return view('anggota.simpanan.history', [
            'title' => 'Riwayat Simpanan',
            'transactions' => $transactions
        ]);
    }
}
