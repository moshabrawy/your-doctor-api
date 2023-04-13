<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\DoctorInfoController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\User\UserInfoController;
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

    Route::get('get_my_addresses', [AddressController::class, 'get_my_addresses']);
    Route::post('add_slot', [TimeSlotController::class, 'add_slot']);
    Route::post('update_slot', [TimeSlotController::class, 'update_slot']);
    Route::get('get_my_slots', [TimeSlotController::class, 'get_my_slots']);
});

Route::get('get_all_specialties', [SpecialtyController::class, 'get_all_specialties']);
Route::get('get_all_doctors', [DoctorInfoController::class, 'get_all_doctors']);
Route::post('get_doctor_details', [DoctorInfoController::class, 'get_doctor_details']);
// Route::view('reset', 'emails.reset_password');
