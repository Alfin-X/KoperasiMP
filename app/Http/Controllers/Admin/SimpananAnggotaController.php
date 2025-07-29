<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Savings;
use App\Models\SavingsTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SimpananAnggotaController extends Controller
{
    /**
     * Display a listing of all members with their savings.
     */
    public function index()
    {
        $members = User::whereHas('role', function($query) {
            $query->where('name', 'anggota');
        })
        ->with(['savings', 'kolat', 'tingkatan'])
        ->orderBy('name')
        ->paginate(20);

        // Calculate total statistics
        $totalMembers = User::whereHas('role', function($query) {
            $query->where('name', 'anggota');
        })->count();

        $totalSavings = Savings::sum('total_balance');
        $totalTransactions = SavingsTransaction::where('status', 'verified')->count();
        $pendingTransactions = SavingsTransaction::where('status', 'pending')->count();

        return view('admin.simpanan-anggota.index', [
            'members' => $members,
            'totalMembers' => $totalMembers,
            'totalSavings' => $totalSavings,
            'totalTransactions' => $totalTransactions,
            'pendingTransactions' => $pendingTransactions,
            'title' => 'Manajemen Simpanan Anggota'
        ]);
    }

    /**
     * Display the specified member's savings details.
     */
    public function show(User $user)
    {
        // Ensure user is an anggota
        if (!$user->hasRole('anggota')) {
            return redirect()->route('admin.simpanan-anggota.index')
                ->with('error', 'User bukan anggota.');
        }

        // Get or create savings record
        $savings = $user->savings ?? new Savings([
            'user_id' => $user->id,
            'simpanan_pokok' => 0,
            'simpanan_wajib' => 0,
            'simpanan_sukarela' => 0,
            'total_balance' => 0,
            'simpanan_pokok_paid' => false
        ]);

        // Get transactions with pagination
        $transactions = $user->savingsTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.simpanan-anggota.show', [
            'user' => $user,
            'savings' => $savings,
            'transactions' => $transactions,
            'title' => 'Detail Simpanan - ' . $user->name
        ]);
    }

    /**
     * Store a new transaction for the specified member.
     */
    public function storeTransaction(Request $request, User $user)
    {
        $request->validate([
            'type' => 'required|in:simpanan_pokok,simpanan_wajib,simpanan_sukarela',
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:pending,verified,rejected'
        ]);

        DB::beginTransaction();
        try {
            // Create transaction
            $transaction = SavingsTransaction::create([
                'user_id' => $user->id,
                'type' => $request->type,
                'amount' => $request->amount,
                'description' => $request->description,
                'status' => $request->status,
                'recorded_by' => Auth::id(),
                'verified_by' => $request->status === 'verified' ? Auth::id() : null,
                'verified_at' => $request->status === 'verified' ? now() : null,
            ]);

            // If verified, update balance immediately
            if ($request->status === 'verified') {
                $savings = Savings::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'simpanan_pokok' => 0,
                        'simpanan_wajib' => 0,
                        'simpanan_sukarela' => 0,
                        'total_balance' => 0,
                        'simpanan_pokok_paid' => false
                    ]
                );
                $savings->updateBalance($request->type, $request->amount);
            }

            DB::commit();

            return redirect()->route('admin.simpanan-anggota.show', $user)
                ->with('success', 'Transaksi berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified transaction.
     */
    public function updateTransaction(Request $request, SavingsTransaction $transaction)
    {
        $request->validate([
            'type' => 'required|in:simpanan_pokok,simpanan_wajib,simpanan_sukarela',
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:500',
            'status' => 'required|in:pending,verified,rejected'
        ]);

        DB::beginTransaction();
        try {
            $oldAmount = $transaction->amount;
            $oldType = $transaction->type;
            $oldStatus = $transaction->status;

            // Update transaction
            $transaction->update([
                'type' => $request->type,
                'amount' => $request->amount,
                'description' => $request->description,
                'status' => $request->status,
                'verified_by' => $request->status === 'verified' ? Auth::id() : null,
                'verified_at' => $request->status === 'verified' ? now() : null,
            ]);

            $savings = $transaction->user->savings;
            if ($savings) {
                // If status changed from verified to something else, reverse the balance
                if ($oldStatus === 'verified' && $request->status !== 'verified') {
                    $savings->updateBalance($oldType, -$oldAmount);
                }
                // If status changed to verified, add to balance
                elseif ($oldStatus !== 'verified' && $request->status === 'verified') {
                    $savings->updateBalance($request->type, $request->amount);
                }
                // If both old and new are verified but amount/type changed
                elseif ($oldStatus === 'verified' && $request->status === 'verified') {
                    // Reverse old amount
                    $savings->updateBalance($oldType, -$oldAmount);
                    // Add new amount
                    $savings->updateBalance($request->type, $request->amount);
                }
            }

            DB::commit();

            return redirect()->route('admin.simpanan-anggota.show', $transaction->user)
                ->with('success', 'Transaksi berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete the specified transaction.
     */
    public function deleteTransaction(SavingsTransaction $transaction)
    {
        DB::beginTransaction();
        try {
            $user = $transaction->user;

            // If transaction was verified, reverse the balance
            if ($transaction->status === 'verified') {
                $savings = $user->savings;
                if ($savings) {
                    $savings->updateBalance($transaction->type, -$transaction->amount);
                }
            }

            $transaction->delete();

            DB::commit();

            return redirect()->route('admin.simpanan-anggota.show', $user)
                ->with('success', 'Transaksi berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
