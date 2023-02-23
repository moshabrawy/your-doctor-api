<?php

use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* User Routes */

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    //Auth Routes
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('register', [UserAuthController::class, 'register']);
});

Route::group(['middleware' => ['api', 'auth:api', 'userAuth']], function ($router) {
    Route::post('logout', [UserAuthController::class, 'logout']);

    Route::get('hello', function () {
        return 'Hello User';
    });
});
