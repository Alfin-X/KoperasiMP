<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperativeTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'member_id',
        'location_id',
        'type',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'final_amount',
        'payment_method',
        'status',
        'transaction_date',
        'notes',
        'processed_by',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    /**
     * Get the member that owns the transaction.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the location where transaction occurred.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the user who processed this transaction.
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Get the transaction details.
     */
    public function details()
    {
        return $this->hasMany(CooperativeTransactionDetail::class, 'transaction_id');
    }

    /**
     * Check if transaction is a sale.
     */
    public function isSale()
    {
        return $this->type === 'sale';
    }

    /**
     * Check if transaction is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Generate transaction number.
     */
    public static function generateTransactionNumber($type)
    {
        $typeCode = strtoupper(substr($type, 0, 3));
        $date = now()->format('Ymd');
        $count = self::where('type', $type)->whereDate('created_at', now())->count() + 1;
        return $typeCode . '-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
