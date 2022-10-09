<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Authorization\Permission;
use App\Models\Authorization\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'phone',
        'type',
        'avatar',
        'active',
        'created_at'
    ];
    protected static $logName = 'User ';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

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
        'created_at' => 'datetime',
    ];
    public function scopeEmployee($query)
    {
        return $query->where('type', 'employee')->where('id', '>', 1);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function hasPermission(Permission $permission)
    {
        return $this->hasAnyRoles($permission->roles);
    }

    public function hasAnyRoles($roles)
    {
        if (is_array($roles) || is_object($roles)) {
            return !!$roles->intersect($this->roles)->count();
        }

        return $this->roles->contains('name', $roles);
    }

    public function isAdmin()
    {
        foreach ($this->roles as $role) {
            if (in_array($role->id, [1, 2])) {
                return true;
            }
        }
        return false;
    }
    public function isDeveloper()
    {
        foreach ($this->roles as $role) {
            if ($role->id == 1) {
                return true;
            }
        }
        return false;
    }
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function getAvatarAttribute($value)
    {
        if ($value) :
            return asset('storage/' . $value);
        endif;
    }
}
