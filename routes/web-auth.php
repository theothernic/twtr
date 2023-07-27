<?php

use Illuminate\Support\Facades\Route;


Route::get('login', \App\Http\Controllers\Auth\LoginController::class);

Route::prefix('auth')->group(function () {
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'handle']);
    Route::post('logout', [\App\Http\Controllers\Auth\LogoutController::class, 'handle']);
});
