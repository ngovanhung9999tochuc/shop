<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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


        Gate::define('admin', function ($user) {
            return $user->checkCustomerRoleAccess();
        });

        Gate::define('product', function ($user) {
            return $user->checkPermissionAccess('product');
        });

        Gate::define('producttype', function ($user) {
            return $user->checkPermissionAccess('product_type');
        });

        Gate::define('supplier', function ($user) {
            return $user->checkPermissionAccess('supplier');
        });

        Gate::define('billin', function ($user) {
            return $user->checkPermissionAccess('input_bill');
        });

        Gate::define('user', function ($user) {
            return $user->checkPermissionAccess('user');
        });

        Gate::define('bill', function ($user) {
            return $user->checkPermissionAccess('bill');
        });
        Gate::define('archive', function ($user) {
            return $user->checkPermissionAccess('archive');
        });

        Gate::define('slide', function ($user) {
            return $user->checkPermissionAccess('slide');
        });
     /*    Gate::define('menu', function ($user) {
            return $user->checkPermissionAccess('menu');
        }); */

        Gate::define('role', function ($user) {
            return $user->checkPermissionAccess('role');
        });
    }
}
