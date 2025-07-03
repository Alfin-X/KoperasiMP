<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\CooperativeSaving;
use App\Models\CooperativeProduct;
use App\Models\CooperativeTransaction;
use App\Models\LocationStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CooperativeController extends Controller
{
    /**
     * Display cooperative dashboard.
     */
    public function index()
    {
        $stats = [
            'total_members' => Member::count(),
            'total_savings' => CooperativeSaving::where('type', 'deposit')->sum('amount'),
            'total_products' => CooperativeProduct::where('is_active', true)->count(),
            'monthly_transactions' => CooperativeTransaction::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.cooperative.index', compact('stats'));
    }

    /**
     * Display member savings management.
     */
    public function memberSavings()
    {
        $members = Member::with(['user', 'cooperativeSavings'])
            ->whereHas('user', function($q) {
                $q->where('is_active', true);
            })
            ->paginate(20);

        return view('admin.cooperative.member-savings', compact('members'));
    }

    /**
     * Show member savings detail.
     */
    public function showMemberSavings(Member $member)
    {
        $savings = $member->cooperativeSavings()
            ->with('processedBy')
            ->orderBy('transaction_date', 'desc')
            ->paginate(20);

        $balances = [
            'pokok' => $member->getCooperativeSavingsByCategory('pokok'),
            'wajib' => $member->getCooperativeSavingsByCategory('wajib'),
            'sukarela' => $member->getCooperativeSavingsByCategory('sukarela'),
        ];

        return view('admin.cooperative.member-savings-detail', compact('member', 'savings', 'balances'));
    }

    /**
     * Store member savings transaction.
     */
    public function storeMemberSavings(Request $request, Member $member)
    {
        $request->validate([
            'type' => 'required|in:deposit,withdrawal',
            'category' => 'required|in:pokok,wajib,sukarela',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $member) {
            $balanceBefore = $member->getCooperativeSavingsByCategory($request->category);
            $amount = $request->type === 'deposit' ? $request->amount : -$request->amount;
            $balanceAfter = $balanceBefore + $amount;

            // Validate withdrawal doesn't exceed balance
            if ($request->type === 'withdrawal' && $balanceAfter < 0) {
                throw new \Exception('Saldo tidak mencukupi untuk penarikan.');
            }

            CooperativeSaving::create([
                'member_id' => $member->id,
                'transaction_number' => CooperativeSaving::generateTransactionNumber(),
                'type' => $request->type,
                'category' => $request->category,
                'amount' => $request->amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'transaction_date' => now(),
                'description' => $request->description,
                'processed_by' => auth()->id(),
            ]);
        });

        return redirect()->back()->with('success', 'Transaksi simpanan berhasil dicatat.');
    }

    /**
     * Create money loan for member.
     */
    public function createLoan(Request $request, Member $member)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        // Check if member has sufficient savings as collateral
        $totalSavings = $member->total_cooperative_savings;
        $maxLoan = $totalSavings * 0.8; // 80% of total savings

        if ($request->amount > $maxLoan) {
            return redirect()->back()->with('error', 'Jumlah pinjaman melebihi batas maksimal (80% dari total simpanan).');
        }

        DB::transaction(function () use ($request, $member) {
            // Record as withdrawal from sukarela category
            $balanceBefore = $member->getCooperativeSavingsByCategory('sukarela');
            $balanceAfter = $balanceBefore - $request->amount;

            CooperativeSaving::create([
                'member_id' => $member->id,
                'transaction_number' => CooperativeSaving::generateTransactionNumber(),
                'type' => 'withdrawal',
                'category' => 'sukarela',
                'amount' => $request->amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'transaction_date' => now(),
                'description' => 'Pinjaman: ' . $request->description,
                'processed_by' => auth()->id(),
            ]);
        });

        return redirect()->back()->with('success', 'Pinjaman berhasil dibuat.');
    }
}
