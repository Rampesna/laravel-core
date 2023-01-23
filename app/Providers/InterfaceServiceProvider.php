<?php

namespace App\Providers;


use App\Interfaces\Eloquent\IPasswordResetService;
use App\Interfaces\Eloquent\IPermissionService;
use App\Interfaces\Eloquent\IPersonalAccessTokenService;
use App\Interfaces\Eloquent\IRoleService;
use App\Interfaces\Eloquent\IUserService;
use App\Services\Eloquent\PasswordResetService;
use App\Services\Eloquent\PermissionService;
use App\Services\Eloquent\PersonalAccessTokenService;
use App\Services\Eloquent\RoleService;
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
        $this->app->bind(IPersonalAccessTokenService::class, PersonalAccessTokenService::class);
        $this->app->bind(IPasswordResetService::class, PasswordResetService::class);
        $this->app->bind(IRoleService::class, RoleService::class);
        $this->app->bind(IPermissionService::class, PermissionService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
