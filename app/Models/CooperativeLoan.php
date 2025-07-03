<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperativeLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'loan_number',
        'loan_amount',
        'interest_rate',
        'loan_term_months',
        'monthly_payment',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'loan_date',
        'due_date',
        'status',
        'purpose',
        'notes',
        'approved_by',
    ];

    protected $casts = [
        'loan_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'loan_date' => 'date',
        'due_date' => 'date',
    ];

    /**
     * Get the member that owns the loan.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the user who approved this loan.
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if loan is overdue.
     */
    public function isOverdue()
    {
        return $this->status === 'active' && $this->due_date < now();
    }

    /**
     * Check if loan is fully paid.
     */
    public function isFullyPaid()
    {
        return $this->status === 'paid' || $this->remaining_amount <= 0;
    }

    /**
     * Calculate monthly payment based on loan amount, interest rate, and term.
     */
    public static function calculateMonthlyPayment($loanAmount, $interestRate, $termMonths)
    {
        if ($interestRate == 0) {
            return $loanAmount / $termMonths;
        }

        $monthlyRate = $interestRate / 100 / 12;
        $payment = $loanAmount * ($monthlyRate * pow(1 + $monthlyRate, $termMonths)) / 
                   (pow(1 + $monthlyRate, $termMonths) - 1);
        
        return round($payment, 2);
    }

    /**
     * Generate loan number.
     */
    public static function generateLoanNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now())->count() + 1;
        return 'LOAN-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Update remaining amount after payment.
     */
    public function updateRemainingAmount()
    {
        $this->remaining_amount = $this->total_amount - $this->paid_amount;
        
        if ($this->remaining_amount <= 0) {
            $this->status = 'paid';
            $this->remaining_amount = 0;
        }
        
        return $this->save();
    }
}
