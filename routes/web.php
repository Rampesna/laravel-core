<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Web\Home\HomeController::class, 'index'])->name('home');
