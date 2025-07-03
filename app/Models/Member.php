<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number',
        'user_id',
        'location_id',
        'current_level_id',
        'join_date',
        'level_achieved_date',
        'membership_type',
        'monthly_fee',
        'status',
        'notes',
    ];

    protected $casts = [
        'join_date' => 'date',
        'level_achieved_date' => 'date',
        'monthly_fee' => 'decimal:2',
    ];

    /**
     * Get the user that owns the member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the location that owns the member.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the current level of the member.
     */
    public function currentLevel()
    {
        return $this->belongsTo(Level::class, 'current_level_id');
    }

    /**
     * Get the attendances for the member.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the SPP payments for the member.
     */
    public function sppPayments()
    {
        return $this->hasMany(SppPayment::class);
    }

    /**
     * Get the cooperative savings for the member.
     */
    public function cooperativeSavings()
    {
        return $this->hasMany(CooperativeSaving::class);
    }

    /**
     * Get the cooperative transactions for the member.
     */
    public function cooperativeTransactions()
    {
        return $this->hasMany(CooperativeTransaction::class);
    }

    /**
     * Get total cooperative savings balance.
     */
    public function getTotalCooperativeSavingsAttribute()
    {
        return $this->cooperativeSavings()
            ->selectRaw('SUM(CASE WHEN type = "deposit" THEN amount ELSE -amount END) as total')
            ->value('total') ?? 0;
    }

    /**
     * Get cooperative savings balance by category.
     */
    public function getCooperativeSavingsByCategory($category)
    {
        return $this->cooperativeSavings()
            ->where('category', $category)
            ->selectRaw('SUM(CASE WHEN type = "deposit" THEN amount ELSE -amount END) as total')
            ->value('total') ?? 0;
    }

    /**
     * Get the cooperative loans for the member.
     */
    public function cooperativeLoans()
    {
        return $this->hasMany(CooperativeLoan::class);
    }

    /**
     * Get active cooperative loans.
     */
    public function activeCooperativeLoans()
    {
        return $this->cooperativeLoans()->where('status', 'active');
    }
}
