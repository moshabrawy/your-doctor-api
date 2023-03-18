<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors(), 'status_code' => 400], 400);
        } else {
            $credentials = request(['email', 'password']);
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Invalid Credentials'], 401);
            }
            $user = auth('api')->user();
            $data = new UserResource($user);
            return response()->json(['user_data' => $data, 'status_code' => 200, 'token' => $token]);
        }
    }

    public function logout()
    {
        auth()->guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'user_type' => [
                'required',
                Rule::in(['user', 'doctor']),
            ],
            // 'gender' => [Rule::in(['male', 'fmale'])],
            // 'birth_date' => 'required',
            // 'country_id' => 'required|exists:App\Models\Country,id',
            'password' => 'required|string|confirmed',
            // 'address' => 'sometimes|required',
            // 'state' => 'sometimes|required',
            // 'country' => 'sometimes|required',
            // 'avatar' => 'sometimes|required',
            // "avatar.*" => 'sometimes|base64mimes:jpg,png,jpeg|base64max:5128'
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors(), 'status_code' => 400], 400);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_type' => $request->user_type === 'user' ? '1' : '0',
                // 'gender' => $request->gender,
                // 'birth_date' => Carbon::parse($request->birth_date)->format('Y-m-d'),
                'password' => Hash::make($request->password),
                // 'avatar' => $request->hasFile('avatar') ? 'Done' : 'no',
            ]);
            // if (!empty($request->address)) {
            //     Address::create([
            //         'user_id' =>  $user->id,
            //         'address' => $request->address,
            //         'state' => $request->state,
            //         'country' => $request->country
            //     ]);
            // }
            return response()->json(['message' => 'Success', 'status_code' => 200], 200);
        }
    }
}
