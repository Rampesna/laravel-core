<?php

use App\Http\Controllers\Api\UserGuard\PermissionController;
use App\Http\Controllers\Api\UserGuard\RoleController;
use App\Http\Controllers\Api\UserGuard\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('user.api.login');
});

Route::middleware([
    'auth:user_api',
])->group(function () {
    Route::get('getProfile', [UserController::class, 'getProfile'])->name('user.api.getProfile');
    Route::get('getAll', [UserController::class, 'getAll'])->name('user.api.getAll');
    Route::get('getById', [UserController::class, 'getById'])->name('user.api.getById');
    Route::get('getByEmail', [UserController::class, 'getByEmail'])->name('user.api.getByEmail');
    Route::get('getCompanies', [UserController::class, 'getCompanies'])->name('user.api.getCompanies');
    Route::post('setSelectedCompanies', [UserController::class, 'setSelectedCompanies'])->name('user.api.setSelectedCompanies');
    Route::get('getSelectedCompanies', [UserController::class, 'getSelectedCompanies'])->name('user.api.getSelectedCompanies');
    Route::get('getRoles', [UserController::class, 'getRoles'])->name('user.api.getRoles');
    Route::post('attachRole', [UserController::class, 'attachRole'])->name('user.api.attachRole');
    Route::post('detachRole', [UserController::class, 'detachRole'])->name('user.api.detachRole');
    Route::post('syncRoles', [UserController::class, 'syncRoles'])->name('user.api.syncRoles');



    Route::group([
        'prefix' => 'roles',
    ], function () {
        Route::get('getAll', [RoleController::class, 'getAll'])->name('roles.api.getAll');
        Route::get('getAllUserRoles', [RoleController::class, 'getAllUserRoles'])->name('roles.api.getAllUserRoles');
        Route::post('create', [RoleController::class, 'create'])->name('roles.api.create');
        Route::put('update', [RoleController::class, 'update'])->name('roles.api.update');
        Route::delete('delete', [RoleController::class, 'delete'])->name('roles.api.delete');
        Route::get('getById', [RoleController::class, 'getById'])->name('roles.api.getById');
        Route::get('getPermissions', [RoleController::class, 'getPermissions'])->name('roles.api.getPermissions');
        Route::post('attachPermission', [RoleController::class, 'attachPermission'])->name('roles.api.attachPermission');
        Route::post('detachPermission', [RoleController::class, 'detachPermission'])->name('roles.api.detachPermission');
        Route::post('syncPermissions', [RoleController::class, 'syncPermissions'])->name('roles.api.syncPermissions');
    });

    Route::group([
        'prefix' => 'permissions',
    ], function () {
        Route::get('getAll', [PermissionController::class, 'getAll'])->name('permissions.api.getAll');
        Route::post('create', [PermissionController::class, 'create'])->name('permissions.api.create');
        Route::put('update', [PermissionController::class, 'update'])->name('permissions.api.update');
        Route::delete('delete', [PermissionController::class, 'delete'])->name('permissions.api.delete');
        Route::get('getById', [PermissionController::class, 'getById'])->name('permissions.api.getById');
        Route::get('getRoles', [PermissionController::class, 'getRoles'])->name('permissions.api.getRoles');
        Route::get('getByParentId', [PermissionController::class, 'getByParentId'])->name('permissions.api.getByParentId');

//        Route::post('attachRole', [PermissionController::class, 'attachRole'])->name('permissions.api.attachRole');
//        Route::post('detachRole', [PermissionController::class, 'detachRole'])->name('permissions.api.detachRole');
//        Route::post('syncRoles', [PermissionController::class, 'syncRoles'])->name('permissions.api.syncRoles');

    });


});
