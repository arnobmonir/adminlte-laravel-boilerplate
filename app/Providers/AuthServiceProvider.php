<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Authorization\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        try {
            $permissions = Permission::with('roles')->get();
        } catch (\Exception $e) {
            return [];
        }

        foreach ($permissions as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                if ($user->isDeveloper()) {
                    return true;
                }
                if ($user->isAdmin()) {
                    return true;
                }
                return $user->hasPermission($permission);
            });
        }

        //
    }
}
