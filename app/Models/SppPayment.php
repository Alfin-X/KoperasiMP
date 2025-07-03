<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'invoice_number',
        'payment_year',
        'payment_month',
        'base_amount',
        'penalty_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'due_date',
        'paid_date',
        'status',
        'payment_method',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'base_amount' => 'decimal:2',
        'penalty_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    /**
     * Get the member that owns the SPP payment.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the user who recorded this payment.
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Check if payment is overdue.
     */
    public function isOverdue()
    {
        return $this->status === 'pending' && $this->due_date < now();
    }

    /**
     * Get remaining amount to be paid.
     */
    public function getRemainingAmountAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }
}
