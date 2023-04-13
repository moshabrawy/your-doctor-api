<?php

namespace App\Http\Controllers;

use App\Models\Address;

class AddressController extends Controller
{
    private $user_type;
    public function __construct()
    {
        $this->user_type = check_user_type();
    }
    
    public function get_my_addresses()
    {
        if ($this->user_type !== 'doctor') {
            return response()->json(['error' => 'Unauthorized!', 'status_code' => 401]);
        }
        $addresses = Address::where('user_id', auth()->user()->id)->get(['id', 'address']);
        return response()->json(['data' => $addresses, 'status_code' => 400]);
    }
}
