<?php

use Illuminate\Support\Facades\Route;

    Route::prefix('account')->group(function () {
        Route::get('register', \App\Http\Controllers\Account\RegisterAccountController::class)->name('account.register');
        Route::post('register', [\App\Http\Controllers\Account\RegisterAccountController::class, 'handle'])->name('account.register.handle');

        Route::get('forgot-password', \App\Http\Controllers\Account\ForgotPasswordController::class)->name('account.forgot');

    });


