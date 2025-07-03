<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'order',
        'requirements',
        'min_training_hours',
        'min_months',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the members for the level.
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'current_level_id');
    }
}
