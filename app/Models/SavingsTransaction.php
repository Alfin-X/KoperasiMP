<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
        'status',
        'recorded_by',
        'verified_by',
        'verified_at',
        'rejection_reason',
        'proof_image',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who recorded the transaction.
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Get the user who verified the transaction.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get the savings record for the user.
     */
    public function savings()
    {
        return $this->belongsTo(Savings::class, 'user_id', 'user_id');
    }

    /**
     * Get formatted amount for display
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'badge-warning';
            case 'verified':
                return 'badge-success';
            case 'rejected':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'Menunggu Verifikasi';
            case 'verified':
                return 'Terverifikasi';
            case 'rejected':
                return 'Ditolak';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get type text
     */
    public function getTypeTextAttribute()
    {
        switch ($this->type) {
            case 'simpanan_pokok':
                return 'Simpanan Pokok';
            case 'simpanan_wajib':
                return 'Simpanan Wajib';
            case 'simpanan_sukarela':
                return 'Simpanan Sukarela';
            default:
                return 'Unknown';
        }
    }

    /**
     * Scope for pending transactions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for verified transactions
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope for rejected transactions
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
