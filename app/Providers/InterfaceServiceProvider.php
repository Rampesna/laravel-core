<?php

namespace App\Providers;


use App\Interfaces\Eloquent\IUserService;
use App\Services\Eloquent\UserService;
use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Eloquent Services
        $this->app->bind(IUserService::class, UserService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
