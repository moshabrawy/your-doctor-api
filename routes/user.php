<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\DoctorInfoController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\User\UserInfoController;
use App\Models\Appointment;
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
    //User Profile Endpoint
    Route::get('get_profile_data', [UserInfoController::class, 'get_profile_data']);
    Route::post('update_user_info', [UserInfoController::class, 'update_user_info']);

    //Address Endpoint
    Route::post('add_new_address', [AddressController::class, 'add_new_address']);
    Route::post('update_address', [AddressController::class, 'update_address']);
    Route::delete('delete_address', [AddressController::class, 'delete_address']);
    Route::get('get_my_addresses', [AddressController::class, 'get_my_addresses']);

    //Time Slots Endpoint
    Route::post('add_slot', [TimeSlotController::class, 'add_slot']);
    Route::post('update_slot', [TimeSlotController::class, 'update_slot']);
    Route::delete('delete_slot', [TimeSlotController::class, 'delete_slot']);
    Route::get('get_my_slots', [TimeSlotController::class, 'get_my_slots']);

    //Appointment
    Route::post('get_dates_by_day', [AppointmentController::class, 'get_dates_by_day']);
    Route::post('booking', [AppointmentController::class, 'booking']);
    Route::get('get_my_appointments', [AppointmentController::class, 'get_my_appointments']);
    Route::post('booking_details', [AppointmentController::class, 'booking_details']);
    Route::post('accept_booking', [AppointmentController::class, 'accept_booking']);
    Route::post('cancel_booking', [AppointmentController::class, 'cancel_booking']);

});

Route::post('search', [SpecialtyController::class, 'search']);
Route::get('get_all_specialties', [SpecialtyController::class, 'get_all_specialties']);
Route::get('get_all_doctors', [DoctorInfoController::class, 'get_all_doctors']);
Route::get('get_doctors_by_specialty', [DoctorInfoController::class, 'get_doctors_by_specialty']);
Route::post('get_doctor_details', [DoctorInfoController::class, 'get_doctor_details']);
// Route::view('reset', 'emails.reset_password');
