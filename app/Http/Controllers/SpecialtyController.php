<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function get_all_specialties()
    {
        $addresses = Specialty::get(['id', 'title', 'icon', 'brief']);
        return response()->json(['data' => $addresses, 'status_code' => 200]);
    }
}
