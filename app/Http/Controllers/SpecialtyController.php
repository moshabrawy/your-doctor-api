<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpecialtyResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DoctorResource;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\DoctorInfo;
use App\Models\Specialty;

class SpecialtyController extends Controller
{
    public function get_all_specialties(Request $request)
    {
        $addresses = Specialty::select('*');
        $addresses = !empty($request->page) ? $addresses->paginate(10) : $addresses->get();
        $data = SpecialtyResource::collection($addresses);

        if (!empty($request->page)) {
            return response()->json(['page_count' => $addresses->lastPage(), 'data' => $data, 'status_code' => 200]);
        } else {
            return response()->json(['data' => $data, 'status_code' => 200]);
        }
    }

    public function search(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'doctor_name' => 'required',
            'specialty_id' => [
                'required',
                Rule::exists('specialties', 'id')
            ]
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()->first(), 'status_code' => 400]);
        } else {
            $doctors = DoctorInfo::where('specialty_id', $request->specialty_id)->with('user')
                ->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->doctor_name%");
                });
            $rows_count = $doctors->count();
            $all_doctors = $doctors->paginate(12);
            $data = DoctorResource::collection($all_doctors);
            return response()->json(['rows_count' => $rows_count, 'count_pages' => $data->lastPage(), 'data' => $data, 'status_code' => 200]);
        }
    }
}
