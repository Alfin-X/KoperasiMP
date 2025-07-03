<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SppPayment;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SppController extends Controller
{
    /**
     * Display SPP payments dashboard.
     */
    public function index()
    {
        $stats = [
            'total_members' => Member::count(),
            'paid_this_month' => SppPayment::whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->where('status', 'paid')
                ->count(),
            'pending_payments' => SppPayment::where('status', 'pending')->count(),
            'overdue_payments' => SppPayment::where('due_date', '<', now())
                ->where('status', 'pending')
                ->count(),
        ];

        $recentPayments = SppPayment::with(['member.user', 'processedBy'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.spp.index', compact('stats', 'recentPayments'));
    }

    /**
     * Display all SPP payments.
     */
    public function payments()
    {
        $payments = SppPayment::with(['member.user', 'processedBy'])
            ->orderBy('due_date', 'desc')
            ->paginate(20);

        return view('admin.spp.payments', compact('payments'));
    }

    /**
     * Show the form for creating a new SPP payment record.
     */
    public function create()
    {
        $members = Member::with('user')->whereHas('user', function($q) {
            $q->where('is_active', true);
        })->get();

        return view('admin.spp.create', compact('members'));
    }

    /**
     * Store a newly created SPP payment record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        SppPayment::create([
            'member_id' => $request->member_id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => 'pending',
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.spp.payments')
            ->with('success', 'Tagihan SPP berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified SPP payment.
     */
    public function edit(SppPayment $spp)
    {
        $members = Member::with('user')->whereHas('user', function($q) {
            $q->where('is_active', true);
        })->get();

        return view('admin.spp.edit', compact('spp', 'members'));
    }

    /**
     * Update the specified SPP payment.
     */
    public function update(Request $request, SppPayment $spp)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $spp->update([
            'member_id' => $request->member_id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.spp.payments')
            ->with('success', 'Tagihan SPP berhasil diperbarui.');
    }

    /**
     * Process payment for SPP.
     */
    public function processPayment(Request $request, SppPayment $spp)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,transfer,savings_deduction',
            'payment_notes' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $spp) {
            $paymentAmount = $request->payment_amount;
            $currentPaidAmount = $spp->paid_amount ?? 0;
            $newPaidAmount = $currentPaidAmount + $paymentAmount;

            $spp->update([
                'paid_amount' => $newPaidAmount,
                'payment_date' => now(),
                'payment_method' => $request->payment_method,
                'payment_notes' => $request->payment_notes,
                'status' => $newPaidAmount >= $spp->amount ? 'paid' : 'partial',
                'processed_by' => auth()->id(),
            ]);
        });

        return redirect()->back()->with('success', 'Pembayaran SPP berhasil diproses.');
    }

    /**
     * Generate bulk SPP for all active members.
     */
    public function generateBulkSpp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date|after:today',
            'description' => 'nullable|string|max:255',
        ]);

        $activeMembers = Member::whereHas('user', function($q) {
            $q->where('is_active', true);
        })->get();

        $createdCount = 0;
        foreach ($activeMembers as $member) {
            // Check if member already has pending SPP for this month
            $existingSpp = SppPayment::where('member_id', $member->id)
                ->whereMonth('due_date', now()->parse($request->due_date)->month)
                ->whereYear('due_date', now()->parse($request->due_date)->year)
                ->where('status', '!=', 'paid')
                ->first();

            if (!$existingSpp) {
                SppPayment::create([
                    'member_id' => $member->id,
                    'amount' => $request->amount,
                    'due_date' => $request->due_date,
                    'status' => 'pending',
                    'description' => $request->description ?? 'SPP Bulanan',
                    'created_by' => auth()->id(),
                ]);
                $createdCount++;
            }
        }

        return redirect()->route('admin.spp.payments')
            ->with('success', "Berhasil membuat {$createdCount} tagihan SPP.");
    }

    /**
     * Show SPP reports.
     */
    public function reports()
    {
        $monthlyStats = SppPayment::selectRaw('
            YEAR(due_date) as year,
            MONTH(due_date) as month,
            COUNT(*) as total_bills,
            SUM(CASE WHEN status = "paid" THEN 1 ELSE 0 END) as paid_bills,
            SUM(amount) as total_amount,
            SUM(CASE WHEN status = "paid" THEN paid_amount ELSE 0 END) as paid_amount
        ')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        return view('admin.spp.reports', compact('monthlyStats'));
    }

    /**
     * Show member SPP history.
     */
    public function memberHistory(Member $member)
    {
        $sppHistory = $member->sppPayments()
            ->with('processedBy')
            ->orderBy('due_date', 'desc')
            ->paginate(20);

        return view('admin.spp.member-history', compact('member', 'sppHistory'));
    }
}
