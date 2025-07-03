<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'location_id',
        'schedule_id',
        'recorded_by',
        'attendance_date',
        'check_in_time',
        'check_out_time',
        'status',
        'notes',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the member that owns the attendance.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the location where attendance was recorded.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the schedule for this attendance.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the user who recorded this attendance.
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Check if member was present.
     */
    public function isPresent()
    {
        return $this->status === 'present';
    }
}
