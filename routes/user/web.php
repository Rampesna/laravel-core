<?php

use Illuminate\Support\Facades\Route;


Route::get('/dashboard', [\App\Http\Controllers\Web\User\DashboardController::class, 'index']);
