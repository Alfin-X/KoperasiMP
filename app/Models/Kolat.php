<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kolat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'schedule_day',
        'schedule_time',
        'description',
        'is_active',
    ];

    protected $casts = [
        'schedule_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    /**
     * Get the users for the kolat.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the schedules for the kolat.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get active members of this kolat
     */
    public function activeMembers()
    {
        return $this->users()->where('is_active', true);
    }
}
