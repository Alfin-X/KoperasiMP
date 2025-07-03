<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'product_id',
        'quantity',
        'reserved_quantity',
    ];

    /**
     * Get the location that owns the stock.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the product for this stock.
     */
    public function product()
    {
        return $this->belongsTo(CooperativeProduct::class, 'product_id');
    }

    /**
     * Get available quantity (not reserved).
     */
    public function getAvailableQuantityAttribute()
    {
        return $this->quantity - $this->reserved_quantity;
    }

    /**
     * Check if stock is sufficient for given quantity.
     */
    public function hasSufficientStock($requestedQuantity)
    {
        return $this->available_quantity >= $requestedQuantity;
    }

    /**
     * Reserve stock for a transaction.
     */
    public function reserveStock($quantity)
    {
        if (!$this->hasSufficientStock($quantity)) {
            return false;
        }

        $this->reserved_quantity += $quantity;
        return $this->save();
    }

    /**
     * Release reserved stock.
     */
    public function releaseReservedStock($quantity)
    {
        $this->reserved_quantity = max(0, $this->reserved_quantity - $quantity);
        return $this->save();
    }

    /**
     * Confirm stock usage (reduce actual quantity and reserved).
     */
    public function confirmStockUsage($quantity)
    {
        $this->quantity -= $quantity;
        $this->reserved_quantity = max(0, $this->reserved_quantity - $quantity);
        return $this->save();
    }
}
