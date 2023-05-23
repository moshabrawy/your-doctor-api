<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allAppointments = Appointment::paginate(10);
        return view('dashboard.appointments.manage', compact('allAppointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allDoctors = User::get()->where('user_type', 2);
        $allPatients = User::get()->where('user_type', 3);
        return view('dashboard.appointments.add', compact('allPatients', 'allDoctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "day" => "required",
            "start_time" => "required",
            "end_time" => "required",
            "pat_name" => "required",
            "doc_name" => "required",
        ]);
        $appointment = new Appointment();
        $appointment->day = $request->day;
        $appointment->start_time = $request->start_time;
        $appointment->end_time = $request->end_time;
        $appointment->pat_id = $request->pat_name;
        $appointment->doc_id = $request->doc_name;
        $appointment->save();
        return redirect()->route('appointments.create')->with('appointmentCreated', 'Done!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $allAppointments = Appointment::where('day', 'like', '%' . $search . '%')->paginate(10);
        return view('dashboard.appointments.all', compact('allAppointments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Appointment::findOrFail($id);
        $patient->delete();
        if (Auth()->User()->user_type == 1) {
            return redirect()->route('appointments.index')->with('success', 'Done');
        } elseif (Auth()->User()->user_type == 2 || Auth()->User()->user_type == 3) {
            return redirect()->route('UserProfile', Auth()->User()->id)->with('success', 'Done');
        }
    }
}
