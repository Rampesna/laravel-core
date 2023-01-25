<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(function () {
    Route::get('login', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'login'])->name('user.web.authentication.login.index');
    Route::get('oAuth', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'oAuth'])->name('user.web.authentication.oAuth');
    Route::get('forgotPassword', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'forgotPassword'])->name('user.web.authentication.forgotPassword');
    Route::get('resetPassword/{token?}', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'resetPassword'])->name('user.web.authentication.resetPassword');
});

Route::middleware([
    'auth:user_web'
])->group(function () {
    Route::get('logout', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'logout'])->name('user.web.authentication.logout');
    Route::get('/dashboard', [\App\Http\Controllers\Web\User\DashboardController::class, 'index'])->name('user.web.dashboard.index');


    Route::prefix('settings')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\SettingsController::class, 'index'])->name('user.web.settings.index');
        Route::get('userRole', [\App\Http\Controllers\Web\User\SettingsController::class, 'userRole'])->name('user.web.settings.userRole');
    });


});


