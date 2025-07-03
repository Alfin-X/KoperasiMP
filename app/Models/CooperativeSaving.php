<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperativeSaving extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'transaction_number',
        'type',
        'category',
        'amount',
        'balance_before',
        'balance_after',
        'transaction_date',
        'description',
        'processed_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    /**
     * Get the member that owns the cooperative saving.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the user who processed this transaction.
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Check if this is a deposit transaction.
     */
    public function isDeposit()
    {
        return $this->type === 'deposit';
    }

    /**
     * Check if this is a withdrawal transaction.
     */
    public function isWithdrawal()
    {
        return $this->type === 'withdrawal';
    }

    /**
     * Generate transaction number.
     */
    public static function generateTransactionNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now())->count() + 1;
        return 'KOP-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
