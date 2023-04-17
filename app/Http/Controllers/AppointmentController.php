<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\PatientDetail;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    private $user_type;
    public function __construct()
    {
        $this->user_type = check_user_type();
    }

    public function get_my_appointments()
    {
        $id = $this->user_type == 'user' ? 'user_id' : 'doctor_id';
        $appointments = Appointment::where($id, auth()->user()->id)->get();
        $data = AppointmentResource::collection($appointments);
        return response()->json(['data' => $data, 'status_code' => 200]);
    }

    public function booking_details(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'booking_id' => [
                'required',
                Rule::exists('appointments', 'id'),
            ]
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()->first(), 'status_code' => 400]);
        } else {
            $booking = Appointment::where('id', $request->booking_id)->get();
            $data = AppointmentResource::collection($booking);
            return response()->json(['data' => $data[0], 'status_code' => 200]);
        }
    }

    public function booking(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'slot_id' => [
                'required',
                Rule::exists('time_slots', 'id'),
            ],
            'doctor_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
            'booking_date' => 'required',
            'patient_name' => 'required',
            'age' => 'required',
            'disease_dec' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors(), 'status_code' => 400]);
        } else {
            $slot = TimeSlot::find($request->slot_id);
            $booking_date = Carbon::parse($request->booking_date)->format('l');
            if ($booking_date != $slot->day_en) {
                return response()->json(['error' => 'Wrong Booking Date', 'status_code' => 400]);
            }
            $appointment = Appointment::create([
                'slot_id' => $request->slot_id,
                'user_id' => auth()->user()->id,
                'doctor_id' => $request->doctor_id,
                'day_date' => $request->booking_date
            ]);
            PatientDetail::create([
                'appointment_id' => $appointment->id,
                'patient_name' => $request->patient_name,
                'age' => $request->age,
                'disease_dec' => $request->disease_dec,
            ]);
            return response()->json(['message' => 'Success!', 'status_code' => 200]);
        }
    }

    public function accept_booking(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'booking_id' => [
                'required',
                Rule::exists('appointments', 'id'),
            ]
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()->first(), 'status_code' => 400]);
        } else {
            $booking = Appointment::where('id', $request->booking_id)->where('doctor_id', auth()->user()->id)->first();

            if (!$booking) {
                return response()->json(['error' => 'The selected booking id is invalid.', 'status_code' => 400]);
            }
            $booking->status = 'accept';
            $booking->save();
            return response()->json(['message' => 'Success! Booking Accepted.', 'status_code' => 200]);
        }
    }

    public function cancel_booking(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'booking_id' => [
                'required',
                Rule::exists('appointments', 'id'),
            ]
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()->first(), 'status_code' => 400]);
        } else {
            $booking = Appointment::where('id', $request->booking_id)->first();
            $booking->status = 'reject';
            $booking->save();
            return response()->json(['message' => 'Success! Booking was canceled.', 'status_code' => 200]);
        }
    }
}
