<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\SendOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;


class UserAuthController extends Controller
{
    public function test_whatsapp(Request $request)
    {
        $sid    = "ACfffe9553bfb6f357cf02b16133369b4f";
        $token  = "0afb4a42c5d9cd0b08bb79010e31aac5";
        $client = new Client($sid, $token);

        // The recipient's phone number and the message to send
        $to = 'whatsapp:' . $request->input('recipient');
        $message = $request->input('message');

        try {
            // Send the message using the Twilio client
            $client->messages->create($to, [
                // 'from' => 'whatsapp:' . config('app.twilio_whatsapp_number'),
                'from' => 'whatsapp:+14155238886',
                'body' => $message,
            ]);
            return response()->json(['message' => 'Message sent successfully.']);
        } catch (\Exception $e) {
            // Log the error message
            return response()->json(['error' =>  $e->getMessage()]);
        }
    }
    public function test_sms()
    {
        $sid    = "ACfffe9553bfb6f357cf02b16133369b4f";
        $token  = "0afb4a42c5d9cd0b08bb79010e31aac5";
        $client = new Client($sid, $token);
        // $message = $client->messages->create(
        //     'whatsapp:' . '+201014018375',
        //     array(
        //         'from' => 'whatsapp:' . '+14155238886',
        //         'body' => 'Hello Mohamed'
        //     )
        // );

        $to = '+201014018375';
        $message = 'Hello from Twilio!';

        try {
            // Send the message using the Twilio client
            $client->messages->create($to, [
                'body' => $message,
                "from" => "+15854605989"
            ]);
            return response()->json(['msg' => 'Message sent successfully.']);
        } catch (RestException $e) {
            // Log the error message
            error_log('Twilio message sending failed: ' . $e->getMessage());
            return response()->json(['msg' => 'Message sending failed. Please try again later.', 'error' => $e->getMessage()]);
        }
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
            'password' => 'required|string|confirmed'
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors(), 'status_code' => 400], 400);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_type' => $request->user_type === 'user' ? '1' : '0',
                'password' => Hash::make($request->password),
            ]);
            return response()->json(['message' => 'Success', 'status_code' => 200], 200);
        }
    }

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
                return response()->json(['error' => 'Invalid Credentials', 'status_code' => 401], 401);
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
