<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperativeTransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'unit_price',
        'discount_per_item',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'discount_per_item' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Get the transaction that owns the detail.
     */
    public function transaction()
    {
        return $this->belongsTo(CooperativeTransaction::class, 'transaction_id');
    }

    /**
     * Get the product for this detail.
     */
    public function product()
    {
        return $this->belongsTo(CooperativeProduct::class, 'product_id');
    }

    /**
     * Calculate total discount for this item.
     */
    public function getTotalDiscountAttribute()
    {
        return $this->discount_per_item * $this->quantity;
    }

    /**
     * Calculate subtotal before discount.
     */
    public function getSubtotalBeforeDiscountAttribute()
    {
        return $this->unit_price * $this->quantity;
    }
}
