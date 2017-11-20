<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Contracts\PermissionRepository::class, \App\Repositories\Eloquent\PermissionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\RoleRepository::class, \App\Repositories\Eloquent\RoleRepositoryEloquent::class);
        //:end-bindings:
    }
}
