<?php

namespace App\Models\Authorization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'label',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    static function rolesUser($user)
    {
        $roles_ids = [];

        foreach ($user->roles as $role) {
            $roles_ids[] = $role->id;
        }

        return $roles_ids;
    }
}
