<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Savings;
use App\Models\SavingsTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KoperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Statistik koperasi
        $totalSimpanan = Savings::sum('total_balance');
        $totalPinjaman = 0; // Placeholder untuk fitur pinjaman
        $pendingApproval = SavingsTransaction::where('status', 'pending')->count();
        $anggotaAktif = User::where('role_id', 3)->where('is_active', true)->count();

        // Transaksi terbaru yang perlu diverifikasi
        $pendingTransactions = SavingsTransaction::with(['user', 'recordedBy'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        // Ambil semua anggota untuk modal
        $allMembers = User::whereHas('role', function($query) {
                $query->where('name', 'anggota');
            })
            ->with(['kolat', 'tingkatan'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.koperasi.index', [
            'title' => 'Manajemen Koperasi',
            'totalSimpanan' => $totalSimpanan,
            'totalPinjaman' => $totalPinjaman,
            'pendingApproval' => $pendingApproval,
            'anggotaAktif' => $anggotaAktif,
            'pendingTransactions' => $pendingTransactions,
            'allMembers' => $allMembers
        ]);
    }

    /**
     * Show all pending transactions for approval
     */
    public function pendingTransactions(Request $request)
    {
        $query = SavingsTransaction::with(['user', 'recordedBy'])
            ->where('status', 'pending');

        // Filter berdasarkan jenis simpanan
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan anggota
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->paginate(15);
        $users = User::where('role_id', 3)->where('is_active', true)->get();

        return view('admin.koperasi.pending-transactions', [
            'title' => 'Transaksi Menunggu Persetujuan',
            'transactions' => $transactions,
            'users' => $users
        ]);
    }

    /**
     * Approve a savings transaction
     */
    public function approveTransaction(Request $request, SavingsTransaction $transaction)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            // Update status transaksi
            $transaction->update([
                'status' => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'description' => $transaction->description . ($request->notes ? ' | Catatan: ' . $request->notes : '')
            ]);

            // Update atau buat record simpanan
            $savings = Savings::firstOrCreate(
                ['user_id' => $transaction->user_id],
                [
                    'simpanan_pokok' => 0,
                    'simpanan_wajib' => 0,
                    'simpanan_sukarela' => 0,
                    'total_balance' => 0,
                    'simpanan_pokok_paid' => false
                ]
            );

            // Update balance berdasarkan jenis simpanan
            $savings->updateBalance($transaction->type, $transaction->amount);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Transaksi berhasil disetujui dan saldo anggota telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Reject a savings transaction
     */
    public function rejectTransaction(Request $request, SavingsTransaction $transaction)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $transaction->update([
            'status' => 'rejected',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->back()
            ->with('success', 'Transaksi berhasil ditolak.');
    }

    /**
     * Add manual transaction (by admin/pelatih)
     */
    public function addTransaction(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:simpanan_pokok,simpanan_wajib,simpanan_sukarela',
            'amount' => 'required|numeric|min:1000',
            'description' => 'required|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            // Buat transaksi langsung terverifikasi
            $transaction = SavingsTransaction::create([
                'user_id' => $request->user_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'description' => $request->description,
                'status' => 'verified',
                'recorded_by' => Auth::id(),
                'verified_by' => Auth::id(),
                'verified_at' => now()
            ]);

            // Update atau buat record simpanan
            $savings = Savings::firstOrCreate(
                ['user_id' => $request->user_id],
                [
                    'simpanan_pokok' => 0,
                    'simpanan_wajib' => 0,
                    'simpanan_sukarela' => 0,
                    'total_balance' => 0,
                    'simpanan_pokok_paid' => false
                ]
            );

            // Update balance
            $savings->updateBalance($request->type, $request->amount);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Transaksi berhasil ditambahkan dan saldo anggota telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan transaksi: ' . $e->getMessage());
        }
    }
}
