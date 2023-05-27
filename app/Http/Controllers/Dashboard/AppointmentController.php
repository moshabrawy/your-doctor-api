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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $allAppointments = Appointment::where('day_date', 'like', '%' . $search . '%')->paginate(10);
        return view('dashboard.appointments.manage', compact('allAppointments'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->delete();
            notify()->success('You are awesome, The Appointment has been deleted successfull!');
        } else {
            notify()->error('Opps!, The Appointment has been deleted before');
        }
        return redirect()->back();
    }
}
