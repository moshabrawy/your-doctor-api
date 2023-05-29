<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Http\Resources\UserInfoResource;
use App\Models\User;
use App\Traits\FilesTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserInfoController extends Controller
{
    use FilesTrait;
    public function get_profile_data(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->get();
        $data = UserInfoResource::collection($user);
        return response()->json(['data' => $data[0], 'status_code' => 200]);
    }

    public function update_user_info(Request $request)
    {
        $user = User::find(auth('api')->user()->id);
        if ($user) {
            $validation = Validator::make($request->all(), [
                'first_name' => 'sometimes|required|string',
                'last_name' => 'sometimes|required|string',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
                'phone' => 'sometimes|required|unique:users,phone,' . $user->id,
                'gender' => ['sometimes', 'required', Rule::in(['male', 'female'])],
                'birth_date' => 'sometimes|required',
                'avatar' => 'sometimes|required',
                "avatar.*" => 'sometimes|base64mimes:jpg,png,jpeg|base64max:5128'
            ]);
            if ($validation->fails()) {
                return response()->json(['error' => $validation->errors(), 'status_code' => 400], 400);
            }

            $first_name = $request->first_name ?? explode(" ", $user->name)[0];
            $last_name = $request->last_name ?? explode(" ", $user->name, 2)[1];
            $full_name = $first_name . ' ' . $last_name;
            $user->name = $full_name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            $user->gender = $request->gender ?? $user->gender;
            $user->birth_date = $request->birth_date ?? $user->birth_date;
            $user->avatar = $request->has('avatar') ? $this->UploudImage($request->avatar, 'profile') : $user->avatar;

            //Update User Password
            if (isset($request->password)) {
                $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'password' => 'required', 'confirmed',
                ]);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()->first(), 'Status Code' => 400], 400);
                }
                if (!(Hash::check($request->get('current_password'), auth('api')->user()->password))) {
                    return response()->json(['message' => 'Current password does not match', 'Status Code' => 400], 400);
                }
                if (strcmp($request->get('current_password'), $request->get('password')) == 0) {
                    return response()->json(['message' => 'New Password cannot be same as your current password', 'Status Code' => 400], 400);
                }
                $user->password = Hash::make($request->password);
            }

            $user->save();
            return response()->json(['message' => 'Data updated success', 'status_code' => 200]);
        } else {
            return response()->json(['error' => 'Fail! Account not found.', 'status_code' => 400]);
        }
    }
}
