<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            return response()->json(['error' => 'Unauthorized! Your are not a doctor', 'status_code' => 401]);
        }
        $addresses = Address::where('user_id', auth()->user()->id)->get(['id', 'address']);
        return response()->json(['data' => $addresses, 'status_code' => 400]);
    }

    public function add_new_address(Request $request)
    {
        if ($this->user_type == 'doctor') {
            $validation = Validator::make($request->all(), [
                'address' => 'required',
                'state' => 'required',
                'country' => 'required'
            ]);
            if ($validation->fails()) {
                return response()->json(['error' => $validation->errors(), 'status_code' => 400], 400);
            } else {
                Address::create([
                    "user_id" => auth('api')->user()->id,
                    'address' => $request->address,
                    'state' => $request->state,
                    'country' => $request->country
                ]);
                return response()->json(['message' => 'Your Address created updated success', 'status_code' => 200]);
            }
        } else {
            return response()->json(['error' => 'Unauthorized! Your are not a doctor', 'status_code' => 401]);
        }
    }

    public function update_address(Request $request)
    {
        if ($this->user_type == 'doctor') {
            $validation = Validator::make($request->all(), [
                'address_id' => 'required',
                'address' => 'sometimes|required',
                'state' => 'sometimes|required',
                'country' => 'sometimes|required'
            ]);
            if ($validation->fails()) {
                return response()->json(['error' => $validation->errors(), 'status_code' => 400], 400);
            } else {
                //Update User Address
                $address = Address::where('user_id', auth('api')->user()->id)->where('id', $request->address_id)->first();
                if (!empty($address)) {
                    $address->address = $request->address ?? $address->address;
                    $address->state   = $request->state ?? $address->state;
                    $address->country = $request->country ?? $address->country;
                    $address->save();
                } else {
                    return response()->json(['error' => 'Address not found', 'status_code' => 400]);
                }
                return response()->json(['message' => 'Your Address updated success', 'status_code' => 200]);
            }
        } else {
            return response()->json(['error' => 'Unauthorized! Your are not a doctor', 'status_code' => 401]);
        }
    }

    public function delete_address(Request $request)
    {
        if ($this->user_type == 'doctor') {
            $validation = Validator::make($request->all(), ['address_id' => 'required']);
            if ($validation->fails()) {
                return response()->json(['error' => $validation->errors(), 'status_code' => 400], 400);
            } else {
                $address = Address::where('user_id', auth('api')->user()->id)->where('id', $request->address_id)->first();
                if (!empty($address)) {
                    $address->delete();
                } else {
                    return response()->json(['error' => 'Address not found', 'status_code' => 400]);
                }
                return response()->json(['message' => 'Your Address Deleted success', 'status_code' => 200]);
            }
        } else {
            return response()->json(['error' => 'Unauthorized! Your are not a doctor', 'status_code' => 401]);
        }
    }
}
