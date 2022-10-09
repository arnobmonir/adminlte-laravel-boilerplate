<?php

namespace App\Models\Authorization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'label',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    static function permissionsRole($role)
    {
        $permissions_ids = [];

        foreach ($role->permissions as $permission) {
            $permissions_ids[] = $permission->id;
        }

        return $permissions_ids;
    }

    static function permissionsId($var)
    {
        return Permission::when($var == 2, function ($query) {
            $query->whereNotIn('permission_group_id', [18]);
        })
            ->when($var == 3, function ($query) {
                $query->whereIn('permission_group_id', [2, 7, 9, 22, 23, 27, 28, 29, 30, 31])
                    ->orWhereIn('id', [29, 34]);
            })
            ->when($var == 4, function ($query) {
                $query->where(function ($query) {
                    $query->whereIn('permission_group_id', [2, 7, 9, 22, 23, 27, 28, 29, 30, 31])
                        ->orWhereIn('id', [29, 34]);
                })
                    ->where('name', 'not like', 'destroy-%')
                    ->where('name', 'not like', 'verify-%')
                    ->where('name', 'not like', 'confirm-%')
                    ->where('name', 'not like', 'pricing-%');
            })
            ->when($var == 5, function ($query) {
                $query->whereIn('permission_group_id', [25]);
            })
            ->when($var == 6, function ($query) {
                $query->whereIn('permission_group_id', [10]);
            })
            ->get()
            ->map(function ($item) {
                return $item->id;
            });
    }
}
