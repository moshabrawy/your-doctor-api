<?php


use App\Http\Controllers\Dashboard\AppointmentController;
use App\Http\Controllers\Dashboard\SpecialtyController;
use App\Http\Controllers\Dashboard\PatientController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

/* Web Routes */
// Auth Controller For All Type Of Users
Route::group(['prefix' => '/', 'namespace' => 'Auth', 'middleware' => 'guest'], function () {
    Route::view('login', 'auth.login')->name('Login');
    Route::POST('post-login', [AdminAuthController::class, 'post_login'])->name('PostLogin');
});

Route::get('/', fn () => redirect()->route('Dashboard'));
Route::group(['prefix' => 'dashboard', 'middleware' => 'admin'], function () {
    Route::GET('/', [AdminController::class, 'dashboard'])->name('Dashboard');
    Route::view('profile/', 'dashboard.profile')->name('AdminProfile');

    //only for profile update
    Route::resource('user', AdminController::class);

    // Manage Doctor Routes
    Route::resource('doctors', DoctorController::class);
    Route::GET('doctors/search', [DoctorController::class, 'search'])->name('doctors.search');

    // Manage Patient Routes
    Route::resource('patients', PatientController::class);
    Route::GET('patients/search', [PatientController::class, 'search'])->name('patients.search');

    // Appointments Routes Start
    Route::resource('appointments', AppointmentController::class);
    Route::GET('appointments/search', [AppointmentController::class, 'search'])->name('appointments.search');

    // Specialties Route Start
    Route::resource('specialties', SpecialtyController::class);
    Route::GET('specialties/search', [SpecialtyController::class, 'search'])->name('specialties.search');

    Route::GET('logout', [AdminAuthController::class, 'logout'])->name('Logout');
});
