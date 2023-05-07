<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;

class AdminController extends Controller

{
    //Admin
    public function dashboard()
    {
        $doctors = User::where('user_type', "0")->get();
        $patients = User::where('user_type', "1")->get();
        $appointments = Appointment::query();
        $all_appointments = $appointments->get();
        $recentAppointments = $appointments->latest()->take(10)->get();
        return view('dashboard.index', compact('appointments', 'doctors', 'patients', 'recentAppointments'));
    }
}
