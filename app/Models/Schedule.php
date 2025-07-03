<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'instructor_id',
        'name',
        'day_of_week',
        'start_time',
        'end_time',
        'target_levels',
        'max_participants',
        'description',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'target_levels' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the location that owns the schedule.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the instructor for this schedule.
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the attendances for this schedule.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
