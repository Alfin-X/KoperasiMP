<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'capacity',
        'facilities',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
    ];

    /**
     * Get the users for the location.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the members for the location.
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get the schedules for the location.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
