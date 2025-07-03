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
        'password',
        'role_id',
        'location_id',
        'phone',
        'birth_date',
        'gender',
        'address',
        'is_active',
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
     * Get the location that owns the user.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the member record associated with the user.
     */
    public function member()
    {
        return $this->hasOne(Member::class);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole($roles)
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        return $this->role && in_array($this->role->name, $roles);
    }

    /**
     * Check if user has permission.
     */
    public function hasPermission($permission)
    {
        if (!$this->role || !$this->role->permissions) {
            return false;
        }

        $permissions = is_string($this->role->permissions)
            ? json_decode($this->role->permissions, true)
            : $this->role->permissions;

        return in_array($permission, $permissions ?? []);
    }
}
