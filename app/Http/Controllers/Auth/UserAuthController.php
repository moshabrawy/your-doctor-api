<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make([
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
            return response()->json(['user_data' => $user, 'status_code' => 200, 'token' => $token]);
        }


        // $data = new UserResource($user);
        // return response()->json(['user_data' => $data, 'status_code' => 200, 'token' => $token]);
    }
}
