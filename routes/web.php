<?php

use App\Http\Controllers\Dashboard\AppointmentController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\PatientController;
use App\Http\Controllers\Dashboard\SpecialtyController;
use App\Http\Controllers\Front\TimeSlotsController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

/* Web Routes */
// Auth Controller For All Type Of Users
Route::group(['prefix' => '/', 'namespace' => 'Auth', 'middleware' => 'guest'], function () {
    Route::view('login', 'auth.login')->name('Login');
    Route::GET('register', [UserController::class, 'showRegister'])->name('Register');
    Route::POST('post-login', [UserController::class, 'postLogin'])->name('PostLogin');
    Route::POST('post-register', [UserController::class, 'postRegister'])->name('PostRegister');
});
Route::GET('logout', [UserController::class, 'logout'])->name('Logout');

Route::group(['prefix' => 'dashboard', 'middleware' => 'admin'], function () {
    Route::GET('/', function () {
        return redirect()->route('Dashboard');
    });
    Route::GET('index', [UserController::class, 'userCount'])->name('Dashboard');
    Route::view('admin/profile/', 'dashboard.user.profile')->name('AdminProfile');

    // Users Routes Start
    Route::group(['prefix' => 'user'], function () {
        // Doctors Routes Start
        Route::GET('add', [SpecialtyController::class, 'indexSpec'])->name('AddUser');
        Route::GET('doctors', [DoctorController::class, 'showDoctors'])->name('Doctors');
        Route::POST('reg-doctor', [DoctorController::class, 'regDoctor'])->name('regDoctor');
        Route::GET('doctor/search', [DoctorController::class, 'search'])->name('SearchDoctor');
        Route::GET('del-doc/{id}', [DoctorController::class, 'destroy'])->name('DeleteDoctor');
        // Patients Routes Start
        Route::GET('patients', [PatientController::class, 'showPatients'])->name('Patients');
        Route::POST('reg-patient', [PatientController::class, 'regPatient'])->name('regPatient');
        Route::GET('patient/search', [PatientController::class, 'search'])->name('SearchPatient');
        Route::GET('del-pat/{id}', [PatientController::class, 'destroy'])->name('DeletePatient');

        Route::get('view/{id}', [UserController::class, 'viewUser'])->name('ViewUser');
    });
    Route::resource('user', UserController::class);
    // Appointments Routes Start
    Route::GET('appointments/search', [AppointmentController::class, 'search'])->name('SearchAppointment');
    Route::resource('appointments', AppointmentController::class);
    // Specialties Route Start
    Route::GET('specialties/search', [SpecialtyController::class, 'search'])->name('SearchSpecialty');
    Route::resource('specialties', SpecialtyController::class);
    // Settings Routes Start
    Route::GET('settings', function () {
        return view('dashboard/settings/index');
    })->name('Settings');
});

// Landing Routes
// Route::GET('/', function () {
//     return redirect()->route('Home');
// });

// Route::group(['prefix' => 'landing'], function () {
//     Route::GET('/', [UserController::class, 'showHome'])->name('Home');
//     Route::GET('/search', [UserController::class, 'search'])->name('Search');
//     Route::GET('doctors', [DoctorController::class, 'showDoctors'])->name('AllDoctors');
//     Route::GET('doctor/{id}', [DoctorController::class, 'viewDoctor'])->name('ViewDoctor');
// });

// Route::group(['prefix' => 'landing', 'middleware' => 'user'], function () {
//     Route::GET('profile/{id}', [UserController::class, 'userProfile'])->name('UserProfile');
//     Route::GET('timeslots/delete/{id}', [TimeSlotsController::class, 'destroy'])->name('SlotDestroy');
//     Route::resource('timeslots', TimeSlotsController::class);
//     Route::get('profile/{id}/edit', [UserController::class, 'edit'])->name('EditUser');
//     Route::PATCH('profile/{user}/update', [UserController::class, 'updateInfo'])->name('UpdateUser');

//     Route::GET('booking/create/{id}', [AppointmentController::class, 'addBooking'])->name('Booking');
//     Route::POST('booking', [AppointmentController::class, 'storeBooking'])->name('StoreBooking');
//     Route::GET('booking/{appointment}/edit', [AppointmentController::class, 'edit'])->name('AppointmentEdit');
//     Route::PATCH('booking/{appointment}/update', [AppointmentController::class, 'update'])->name('AppointmentUpdate');
//     Route::GET('booking/delete/{id}', [AppointmentController::class, 'destroy'])->name('AppointmentDestroy');
// });
