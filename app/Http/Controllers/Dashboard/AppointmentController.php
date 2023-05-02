<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\PatientDetail;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $allAppointments = Appointment::paginate(10);
        return view('dashboard.appointments.all', compact('allAppointments'));
    }

    public function create()
    {
        $allDoctors = User::get()->where('user_type', 2);
        $allPatients = User::get()->where('user_type', 3);
        return view('dashboard.appointments.create', compact('allPatients', 'allDoctors'));
    }

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

    public function search(Request $request)
    {
        $search = $request->get('search');
        $allAppointments = Appointment::where('day', 'like', '%' . $search . '%')->paginate(10);
        return view('dashboard.appointments.all', compact('allAppointments'));
    }

    public function addBooking($id)
    {
        $doctor = User::findOrFail($id)->whereHas('timeslots', function ($q) use ($id) {
            $q->where('doc_id', $id);
        })->with('timeslots')->get()[0];
        return view('landing.booking.add', compact('doctor'));
    }

    public function storeBooking(Request $request)
    {
        $timestamp = strtotime($request->day);
        $day = date('l', $timestamp);
        $docTimeSlots = TimeSlot::where('doc_id', $request->doc_id)->where('week_day', $day)->get();

        foreach ($docTimeSlots as $slot) {
            $doc = $slot->num_of_booking;
            $booking_num = $slot->num_of_booking;
            $end_time = $slot->end_time;
            $start_time = $slot->start_time;
            $start = strtotime($start_time);
            $end = strtotime($end_time);
            $slot = $end - $start;
            $div = $slot / $booking_num;
            $result = gmdate("i:s", $div);
        }
        $request->validate([
            "doc_id" => "required",
            "day" => "required|after_or_equal:today",
            "start_time" => "required|date_format:H:i|before:time_start",
            "end_time" => "required|date_format:H:i|after:time_start",
            "patient_name" => "required",
            "patient_age" => "required",
        ]);
        $appointment = new Appointment();
        $appointment->day = $request->day;
        $appointment->start_time = $request->start_time;
        $appointment->end_time = $request->end_time;
        $appointment->pat_id = Auth::user()->id;
        $appointment->doc_id = $request->doc_id;
        $appointment->save();

        $patientDetail = new PatientDetail();
        $patientDetail->patient_name = $request->patient_name;
        $patientDetail->patient_age = $request->patient_age;
        $patientDetail->patient_phone = $request->patient_phone;
        $patientDetail->booking_id = $appointment->id;
        $patientDetail->save();
        return redirect()->route('UserProfile', Auth()->User()->id)->with('BookingSuccessfully', 'Booking Successfully!');
    }

    public function edit(Appointment $appointment)
    {
        $allDoctors = User::get()->where('user_type', 2);
        $allPatients = User::get()->where('user_type', 3);
        $user_id = Auth()->User()->id;

        if (Auth()->User()->user_type == 1) {
            return view('dashboard.appointments.edit', compact('allPatients', 'allDoctors', 'appointment'));
        } elseif (Auth()->User()->user_type == 2 || Auth()->User()->user_type == 3) {
            if ($appointment->pat_id == $user_id || $appointment->doc_id == $user_id) {
                return view('landing.booking.edit', compact('allDoctors', 'appointment'));
            } else {
                return redirect()->route('UserProfile', $user_id);
            }
        }
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            "doc_id" => "required",
            "day" => "required|after_or_equal:today",
            "start_time" => "required|before:end_time",
            "end_time" => "required|after:start_time",
        ]);

        $appointment = Appointment::findOrFail($appointment->id);
        $appointment->update([
            'pat_id'     => Auth()->user()->id,
            'doc_id'     => $request->doc_id,
            'day'        => $request->day,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
        ]);

        if (Auth::user()->user_type == 1) {

            return redirect()->route('appointments.index')->with('appointmentUpdated', 'Done');
        } elseif (Auth::user()->user_type == 2) {

            return redirect()->route('UserProfile', Auth()->User()->id)->with('BookingSuccessfully', 'Booking Successfully!');
        } elseif (Auth::user()->user_type == 3) {
            // $patientDetail = PatientDetail::where('booking_id', $appointment->id)->first();
            $appointment->PatientDetails->update([
                'appointment.booking_id'    => $appointment->id,
                'appointment.patient_name'  => $request->patient_name,
                'appointment.patient_age'   => $request->patient_age,
                'appointment.patient_phone' => $request->patient_phone,
            ]);

            return redirect()->route('UserProfile', Auth()->User()->id)->with('BookingSuccessfully', 'Booking Successfully!');
        }
    }

    public function destroy($id)
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
