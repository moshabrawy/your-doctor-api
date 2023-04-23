<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function get_all_specialties()
    {
        $addresses = Specialty::get();
        $data = SpecialtyResource::collection($addresses);
        return response()->json(['data' => $data, 'status_code' => 200]);
    }
}
