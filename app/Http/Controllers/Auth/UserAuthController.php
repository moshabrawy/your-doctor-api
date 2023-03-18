<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserInfoResource;
use App\Http\Resources\UserResource;
use App\Mail\SendOtpMail;
use App\Models\Address;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
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

    public function get_profile_data(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->get();
        $data = UserInfoResource::collection($user);
        return response()->json(['data' => $data[0], 'status_code' => 200]);
    }

    // Reset Password
    public function send_verification_code(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:App\Models\User,email',
        ]);
        if ($validation->fails()) {
            return response()->json(['status_code' => 400, 'error' => $validation->errors()]);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->verification_code = random_int(100000, 999999);
                $user->updated_at = Carbon::now()->addMinute(5)->timestamp;
                $user->save();
                Mail::to($user->email)->send(new SendOtpMail($user));
                return response()->json(['status_code' => 200, 'message' => 'Success']);
            }
        }
    }

    public function validate_verification_code(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'verification_code' => 'required|exists:App\Models\User,verification_code',
        ]);
        if ($validation->fails()) {
            return response()->json(['status_code' => 400, 'error' => $validation->errors()]);
        } else {
            $user = User::where('verification_code', $request->verification_code)->where(function ($query) {
                $query->whereDate('updated_at', Carbon::now());
                $query->whereTime('updated_at', '>=', Carbon::now());
            })->first();
            if ($user) {
                return response()->json(['verification_code' => 'Valid', 'user_id' => $user->id, 'status_code' => 200]);
            } else {
                return response()->json(['verification_code' => 'Invalid', 'status_code' => 200]);
            }
        }
    }

    public function change_password(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|exists:App\Models\User,id',
            'password' => 'required|confirmed',
        ]);
        if ($validation->fails()) {
            return response()->json(['status_code' => 400, 'error' => $validation->errors()]);
        } else {
            $user = User::where('id', $request->user_id)->first();
            $user->password = Hash::make($request['password']);
            $user->save();
            return response()->json(['message' => 'Your password has been changed successfully.', 'status_code' => 200]);
        }
    }
}
