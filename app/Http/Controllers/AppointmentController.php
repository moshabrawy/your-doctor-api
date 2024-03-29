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
        $appointments = Appointment::where($id, auth()->user()->id);
        $rows_count = $appointments->count();
        $all_appointments = $appointments->paginate('10');
        $data = AppointmentResource::collection($all_appointments);
        return response()->json(['rows_count' => $rows_count, 'count_pages' => $data->lastPage(), 'data' => $data, 'status_code' => 200]);
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
            return response()->json(['error' => $validation->errors()->first(), 'status_code' => 400], 400);
        } else {
            $booking = Appointment::where('id', $request->booking_id)->get();
            $data = AppointmentResource::collection($booking);
            return response()->json(['data' => $data[0], 'status_code' => 200], 200);
        }
    }

    public function get_dates_by_day(Request $request)
    {
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addMonths(2);
        $dates = [];
        $currentDate = Carbon::parse($start_date)->next($request->day_name);
        while ($currentDate->lte(Carbon::parse($end_date))) {
            $dates[] = $currentDate->format('Y/m/d');
            $currentDate = $currentDate->next($request->day_name);
        }
        return response()->json(['dates' => $dates, 'status_code' => 200]);
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
            return response()->json(['error' => $validation->errors()->first(), 'status_code' => 400], 400);
        } else {
            $slot = TimeSlot::find($request->slot_id);
            $booking_date = Carbon::parse($request->booking_date)->format('l');
            if ($booking_date != $slot->day_en) {
                return response()->json(['error' => 'Wrong Booking Date' . $booking_date, 'status_code' => 400], 400);
            }
            $appointment = Appointment::create([
                'slot_id' => $request->slot_id,
                'user_id' => auth()->user()->id,
                'doctor_id' => $request->doctor_id,
                'day_date' => Carbon::parse($request->booking_date)->format('Y-m-d')
            ]);
            PatientDetail::create([
                'appointment_id' => $appointment->id,
                'patient_name' => $request->patient_name,
                'age' => $request->age,
                'disease_dec' => $request->disease_dec,
            ]);
            return response()->json(['message' => 'Success!', 'status_code' => 200], 200);
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
