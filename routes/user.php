<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\DoctorInfoController;
use App\Http\Controllers\User\UserInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* User Routes */
Route::post('sms', [UserAuthController::class, 'test_sms']);
Route::post('whatsapp', [UserAuthController::class, 'test_whatsapp']);

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    //Auth Routes
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('send_verification_code', [UserAuthController::class, 'send_verification_code']);
    Route::post('validate_verification_code', [UserAuthController::class, 'validate_verification_code']);
    Route::post('change_password', [UserAuthController::class, 'change_password']);
});

Route::group(['middleware' => ['api', 'auth:api', 'userAuth']], function ($router) {
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::get('get_profile_data', [UserInfoController::class, 'get_profile_data']);
    Route::post('update_user_info', [UserInfoController::class, 'update_user_info']);
    Route::get('get_all_doctors', [DoctorInfoController::class, 'get_all_doctors']);
});

// Route::view('reset', 'emails.reset_password');
