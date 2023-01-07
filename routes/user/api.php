<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(function () {
    Route::post('login', [\App\Http\Controllers\Api\User\UserController::class, 'login'])->name('user.api.login');
});

Route::middleware([
    'auth:user_api',
])->group(function () {

    Route::get('getProfile', [\App\Http\Controllers\Api\User\UserController::class, 'getProfile'])->name('user.api.getProfile');
    Route::get('getAll', [\App\Http\Controllers\Api\User\UserController::class, 'getAll'])->name('user.api.getAll');
    Route::get('getById', [\App\Http\Controllers\Api\User\UserController::class, 'getById'])->name('user.api.getById');
    Route::get('getByEmail', [\App\Http\Controllers\Api\User\UserController::class, 'getByEmail'])->name('user.api.getByEmail');
});
