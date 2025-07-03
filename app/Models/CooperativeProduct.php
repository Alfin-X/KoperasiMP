<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperativeProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'category',
        'purchase_price',
        'selling_price',
        'stock_quantity',
        'min_stock',
        'unit',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the transaction details for this product.
     */
    public function transactionDetails()
    {
        return $this->hasMany(CooperativeTransactionDetail::class, 'product_id');
    }

    /**
     * Get the location stocks for this product.
     */
    public function locationStocks()
    {
        return $this->hasMany(LocationStock::class, 'product_id');
    }

    /**
     * Check if product is low stock.
     */
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->min_stock;
    }

    /**
     * Get profit margin.
     */
    public function getProfitMarginAttribute()
    {
        if ($this->purchase_price == 0) {
            return 0;
        }
        return (($this->selling_price - $this->purchase_price) / $this->purchase_price) * 100;
    }

    /**
     * Generate product code.
     */
    public static function generateProductCode($category)
    {
        $categoryCode = strtoupper(substr($category, 0, 3));
        $count = self::where('category', $category)->count() + 1;
        return $categoryCode . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
