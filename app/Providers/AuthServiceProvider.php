<?php

namespace App\Providers;

use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * @param \App\User $user
         * @return boolean
         */
        Gate::define('edit-products', function (User $user) {
            $roles = ['admin'];

            return in_array($user->role, $roles);
        });

        /**
         * @param \App\User $user
         * @return boolean
         */
        Gate::define('edit-users', function (User $user) {
            $roles = ['admin'];

            return in_array($user->role, $roles);
        });
    }
}
