<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DoctorInfoController extends Controller
{
    public function get_all_doctors()
    {
        $doctors = User::where('user_type', '0');
        $rows_count = $doctors->count();
        $all_doctors = $doctors->paginate(10);
        $data = DoctorResource::collection($all_doctors);
        return response()->json(['rows_count' => $rows_count, 'count_pages' => $data->lastPage(), 'data' => $data, 'status_code' => 200]);
    }
    public function get_doctor_details(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'doctor_id' => 'required',
            'details' => [
                'required',
                Rule::in([true, false]),
            ],
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors(), 'status_code' => 400]);
        } else {
            $doctor = User::where('user_type', '0')->where('id', $request->doctor_id)->get();
            if (count($doctor) > 0) {
                $data = DoctorResource::collection($doctor);
                return response()->json(['data' => $data[0], 'status_code' => 200]);
            } else {
                return response()->json(['error' => 'Invalid Data', 'status_code' => 400]);
            }
        }
    }
}
