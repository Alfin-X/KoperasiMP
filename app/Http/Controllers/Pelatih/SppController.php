<?php

namespace App\Http\Controllers\Pelatih;

use App\Http\Controllers\Controller;
use App\Models\SppPayment;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SppController extends Controller
{
    /**
     * Display SPP payments for trainer's location.
     */
    public function index()
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        // Get members from trainer's location
        $memberIds = Member::whereHas('user', function($q) use ($locationId) {
            $q->where('location_id', $locationId)->where('is_active', true);
        })->pluck('id');

        $stats = [
            'total_members' => $memberIds->count(),
            'paid_this_month' => SppPayment::whereIn('member_id', $memberIds)
                ->whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->where('status', 'paid')
                ->count(),
            'pending_payments' => SppPayment::whereIn('member_id', $memberIds)
                ->where('status', 'pending')
                ->count(),
            'overdue_payments' => SppPayment::whereIn('member_id', $memberIds)
                ->where('due_date', '<', now())
                ->where('status', 'pending')
                ->count(),
        ];

        $recentPayments = SppPayment::with(['member.user', 'processedBy'])
            ->whereIn('member_id', $memberIds)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('pelatih.spp.index', compact('stats', 'recentPayments'));
    }

    /**
     * Display SPP payments for trainer's location.
     */
    public function payments()
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        // Get members from trainer's location
        $memberIds = Member::whereHas('user', function($q) use ($locationId) {
            $q->where('location_id', $locationId)->where('is_active', true);
        })->pluck('id');

        $payments = SppPayment::with(['member.user', 'processedBy'])
            ->whereIn('member_id', $memberIds)
            ->orderBy('due_date', 'desc')
            ->paginate(20);

        return view('pelatih.spp.payments', compact('payments'));
    }

    /**
     * Process payment for SPP.
     */
    public function processPayment(Request $request, SppPayment $spp)
    {
        $user = auth()->user();
        
        // Verify the SPP belongs to a member in trainer's location
        $memberLocationId = $spp->member->user->location_id ?? null;
        if ($memberLocationId !== $user->location_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memproses pembayaran ini.');
        }

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
     * Show member SPP history for trainer's location.
     */
    public function memberHistory(Member $member)
    {
        $user = auth()->user();
        
        // Verify the member belongs to trainer's location
        $memberLocationId = $member->user->location_id ?? null;
        if ($memberLocationId !== $user->location_id) {
            return redirect()->route('pelatih.spp.payments')->with('error', 'Anda tidak memiliki akses untuk melihat data anggota ini.');
        }

        $sppHistory = $member->sppPayments()
            ->with('processedBy')
            ->orderBy('due_date', 'desc')
            ->paginate(20);

        return view('pelatih.spp.member-history', compact('member', 'sppHistory'));
    }

    /**
     * Show SPP reports for trainer's location.
     */
    public function reports()
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        // Get members from trainer's location
        $memberIds = Member::whereHas('user', function($q) use ($locationId) {
            $q->where('location_id', $locationId)->where('is_active', true);
        })->pluck('id');

        $monthlyStats = SppPayment::selectRaw('
            YEAR(due_date) as year,
            MONTH(due_date) as month,
            COUNT(*) as total_bills,
            SUM(CASE WHEN status = "paid" THEN 1 ELSE 0 END) as paid_bills,
            SUM(amount) as total_amount,
            SUM(CASE WHEN status = "paid" THEN paid_amount ELSE 0 END) as paid_amount
        ')
        ->whereIn('member_id', $memberIds)
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();

        return view('pelatih.spp.reports', compact('monthlyStats'));
    }
}
