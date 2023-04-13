<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimeSlotResource;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimeSlotController extends Controller
{
    private $user_type;
    public function __construct()
    {
        $this->user_type = check_user_type();
    }

    public function add_slot(Request $request)
    {
        if ($this->user_type !== 'doctor') {
            return response()->json(['error' => 'Unauthorized!', 'status_code' => 401]);
        }
        $validation = Validator::make($request->all(), [
            'address_id' => 'required',
            'day_en' => 'required',
            'day_ar' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors(), 'status_code' => 400]);
        } else {
            $doctor = auth()->user();
            if (TimeSlot::where('user_id', $doctor->id)->where('day_en', $request->day_en)->exists()) {
                return response()->json(['error' => 'Fail! You added this day before. Please try another day.', 'status_code' => 400]);
            }
            TimeSlot::create([
                'user_id' => $doctor->id,
                'address_id' => $request->address_id,
                'day_en' => $request->day_en,
                'day_ar' => $request->day_ar,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);
            return response()->json(['message' => 'Create Success!', 'status_code' => 200]);
        }
    }
    public function update_slot(Request $request)
    {
        if ($this->user_type !== 'doctor') {
            return response()->json(['error' => 'Unauthorized!', 'status_code' => 401]);
        }
        $validation = Validator::make($request->all(), [
            'slot_id' => 'required',
            'address_id' => 'sometimes|required',
            'day_en' => 'sometimes|required',
            'day_ar' => 'sometimes|required',
            'start_time' => 'sometimes|required',
            'end_time' => 'sometimes|required',
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors(), 'status_code' => 400]);
        }
        $doctor = auth()->user();
        if (TimeSlot::where('id', '<>', $request->slot_id)->where('user_id', $doctor->id)->where('day_en', $request->day_en)->exists()) {
            return response()->json(['error' => 'Fail! You added this day before. Please try another day.', 'status_code' => 400]);
        }
        $slot = TimeSlot::where('id', $request->slot_id)->where('user_id', auth()->user()->id)->first();
        if (!$slot) {
            return response()->json(['error' => 'Invalid', 'status_code' => 400]);
        }
        $slot->address_id = $request->address_id ?? $slot->address_id;
        $slot->day_en = $request->day_en ?? $slot->day_en;
        $slot->day_ar = $request->day_ar ?? $slot->day_ar;
        $slot->start_time = $request->start_time ?? $slot->start_time;
        $slot->end_time = $request->end_time ?? $slot->end_time;
        $slot->save();
        return response()->json(['message' => 'Update Success!', 'status_code' => 200]);
    }
    public function get_my_slots()
    {
        $doctor_id = auth()->user()->id;
        $slots = TimeSlot::where('user_id', $doctor_id)->get();
        $data = TimeSlotResource::collection($slots);
        return response()->json(['data' => $data, 'status_code' => 200]);
    }
}
