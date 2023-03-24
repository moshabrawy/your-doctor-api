<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorInfoController extends Controller
{
    public function get_all_doctors()
    {
        $doctors = User::where('user_type', '0')->get();
        $data = DoctorResource::collection($doctors);
        return response()->json(['data' => $data, 'status_code' => 200]);
    }
}
