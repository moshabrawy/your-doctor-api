<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Address;
use App\Models\TimeSlot;
use App\Models\Specialty;
use Facade\FlareClient\Time\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function showDoctors()
    {
        $allDoctors = User::where('user_type', 2)->with('doctor')->with('doctor.specialty')->with('address')->paginate(15);
        if (!Auth::user()) {
            return view('landing.doctors.all', compact('allDoctors'));
        } elseif (Auth::user()->user_type == 1) {
            return view('dashboard.user.doctors', compact('allDoctors'));
        } else {
            return view('landing.doctors.all', compact('allDoctors'));
        }
    }

    public function regDoctor(Request $request)
    {
        $request->validate([
            'doc_name'        => 'required',
            'email'           => 'email|required',
            'password'        => 'required',
            'confirmPassword' => 'required|same:password',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone'           => 'required',
            'gender'          => 'required',
            'specialty'          => 'required',
        ]);
        $user = new User();
        $user->name = $request->doc_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->gender = $request->gender;
        $user->birth_date = $request->birth_date;
        $user->phone = $request->phone;
        $user->user_type = 2;
        //upload user avatar
        if ($request->hasFile('avatar')) {
            $user->avatar = Storage::disk('public')->put('upload/avatars', $request->file('avatar'));
        }
        $user->save();

        $doctor = new Doctor();
        $doctor->bio = $request->bio;
        $doctor->fees = $request->fees;
        $doctor->user_id = $user->id;
        $doctor->specialty_id = $request->specialty;
        $doctor->save();

        $address = new Address();
        $address->city = $request->city;
        $address->state = $request->state;
        $address->postal_code = $request->postal_code;
        $address->user_id = $user->id;
        $address->save();

        return redirect()->route('Doctors');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $allDoctors = User::where('name', 'like', '%' . $search . '%')->where('user_type', 2)->paginate(10);
        return view('dashboard.user.doctors', compact('allDoctors'));
    }

    public function destroy($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->delete();

        return redirect()->route('Doctors')->with('success', 'Done');
    }

    public function viewDoctor($id)
    {
        $doctor = User::findOrFail($id);
        $docTimeSlots = TimeSlot::where('doc_id', $id)->get();
        $result = '';
        foreach ($docTimeSlots as $slot) {
            $booking_num = $slot->num_of_booking;
            $end_time = $slot->end_time;
            $start_time = $slot->start_time;
            $start = strtotime($start_time);
            $end = strtotime($end_time);
            $slot = $end - $start;
            $div = $slot / $booking_num;
            $result = gmdate("i:s", $div);
        }
        if($result > 0){
            return view('landing.doctors.view', compact('doctor', 'docTimeSlots', 'result'));
        }else{
            return view('landing.doctors.view', compact('doctor', 'docTimeSlots'));
        }
    }
}
