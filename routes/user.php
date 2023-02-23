<?php

use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* User Routes */

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    //Auth Routes
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('adv_register', [UserAuthController::class, 'register'])->name('adv_register');
    Route::post('aff_register', [UserAuthController::class, 'register'])->name('aff_register');
});

Route::group(['middleware' => ['api', 'auth:api', 'userAuth']], function ($router) {
    Route::get('hello', function () {
        return 'Hello User';
    });
});
