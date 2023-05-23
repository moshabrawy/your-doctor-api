<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Traits\FilesTrait;
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller

{
    use FilesTrait;
    //Admin
    public function dashboard()
    {
        $doctors = User::where('user_type', "0")->get();
        $patients = User::where('user_type', "1")->get();
        $appointments = Appointment::query();
        $all_appointments = $appointments->get();
        $recentAppointments = $appointments->latest()->take(10)->get();
        return view('dashboard.index', compact('appointments', 'doctors', 'patients', 'recentAppointments'));
    }

    public function update(Request $request){
        $admin = Admin::find(auth('admin')->user()->id);
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required|email|unique:users,email,' . $admin->id,
            'phone' => 'sometimes|required|unique:users,phone,' . $admin->id,
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $admin->name  = $request->name ?? $admin->name;
            $admin->email = $request->email ?? $admin->email;
            $admin->phone = $request->phone ?? $admin->phone;
            $admin->gender = $request->gender ?? $admin->gender;

            //upload admin avatar
            if ($request->file('avatar')) {
                // return $request->avatar;
                $admin->avatar = $this->UploudAvatar($request->avatar, 'admin-avatars');
            }

            //Update password
            if (!empty($request->password)) {
                $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'password' => 'required', 'confirmed',
                ]);
                if ($validator->fails()) {
                    return Redirect::back()->with('validator', 'Current password does not match');
                }
                if (!(Hash::check($request->get('current_password'), $admin->password))) {
                    return Redirect::back()->with('current_password', 'Current password does not match');
                }
                if (strcmp($request->get('current_password'), $request->get('password')) == 0) {
                    return Redirect::back()->with('new_password', 'New Password cannot be same as your current password');
                }
                $admin->password = Hash::make($request->password);
            }

            $admin->save();
            notify()->success('You are awesome, your data was Updated successfully.');
            return redirect()->route('AdminProfile');
        }
    }

}
