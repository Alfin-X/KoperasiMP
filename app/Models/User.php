<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'member_id',
        'tingkatan',
        'join_date',
        'role_id',
        'kolat_id',
        'is_active',
        'address',
        'birth_date',
        'gender',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'join_date' => 'date',
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the kolat that owns the user.
     */
    public function kolat()
    {
        return $this->belongsTo(Kolat::class);
    }

    /**
     * Get the savings for the user.
     */
    public function savings()
    {
        return $this->hasOne(Savings::class);
    }

    /**
     * Get the savings transactions for the user.
     */
    public function savingsTransactions()
    {
        return $this->hasMany(SavingsTransaction::class);
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is pelatih
     */
    public function isPelatih()
    {
        return $this->hasRole('pelatih');
    }

    /**
     * Check if user is anggota
     */
    public function isAnggota()
    {
        return $this->hasRole('anggota');
    }
}
