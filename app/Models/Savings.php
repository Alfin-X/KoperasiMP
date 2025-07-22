<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Savings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'simpanan_pokok',
        'simpanan_wajib',
        'simpanan_sukarela',
        'total_balance',
        'simpanan_pokok_paid',
    ];

    protected $casts = [
        'simpanan_pokok' => 'decimal:2',
        'simpanan_wajib' => 'decimal:2',
        'simpanan_sukarela' => 'decimal:2',
        'total_balance' => 'decimal:2',
        'simpanan_pokok_paid' => 'boolean',
    ];

    /**
     * Get the user that owns the savings.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the savings transactions for the savings.
     */
    public function transactions()
    {
        return $this->hasMany(SavingsTransaction::class, 'user_id', 'user_id');
    }

    /**
     * Update balance based on transaction type and amount
     */
    public function updateBalance($type, $amount)
    {
        switch ($type) {
            case 'simpanan_pokok':
                $this->simpanan_pokok += $amount;
                $this->simpanan_pokok_paid = true;
                break;
            case 'simpanan_wajib':
                $this->simpanan_wajib += $amount;
                break;
            case 'simpanan_sukarela':
                $this->simpanan_sukarela += $amount;
                break;
        }

        $this->total_balance = $this->simpanan_pokok + $this->simpanan_wajib + $this->simpanan_sukarela;
        $this->save();
    }

    /**
     * Get formatted balance for display
     */
    public function getFormattedBalanceAttribute()
    {
        return 'Rp ' . number_format($this->total_balance, 0, ',', '.');
    }

    /**
     * Get formatted simpanan pokok for display
     */
    public function getFormattedSimpananPokokAttribute()
    {
        return 'Rp ' . number_format($this->simpanan_pokok, 0, ',', '.');
    }

    /**
     * Get formatted simpanan wajib for display
     */
    public function getFormattedSimpananWajibAttribute()
    {
        return 'Rp ' . number_format($this->simpanan_wajib, 0, ',', '.');
    }

    /**
     * Get formatted simpanan sukarela for display
     */
    public function getFormattedSimpananSukarelaAttribute()
    {
        return 'Rp ' . number_format($this->simpanan_sukarela, 0, ',', '.');
    }
}
