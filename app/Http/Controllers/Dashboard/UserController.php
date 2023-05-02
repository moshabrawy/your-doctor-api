<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Address;
use App\Models\TimeSlot;
use App\Models\Specialty;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function showHome()
    {
        $allSpecialties = Specialty::all();
        $allStates = Address::all();
        $doctors = Doctor::orderBy('id', 'DESC')->take(4)->get();
        // $doctors = User::where('user_type', 2)->orderBy('id', 'DESC')->take(4)->get();
        return view('landing.home', compact('doctors', 'allSpecialties', 'allStates'));
    }
    public function showRegister()
    {
        $allSpecialties = Specialty::get();
        return view('auth.register', compact('allSpecialties'));
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            'email'    => 'email|required',
            'password' => 'required'
        ]);

        $cre = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($cre)) {
            if (Auth::user()->user_type == 1) {
                session()->flash('success', 'Welcome ' . Auth::user()->name);
                return redirect()->route('Dashboard');
            } elseif (Auth::user()->user_type == 2) {
                session()->flash('success', 'Welcome ' . Auth::user()->name);
                return redirect()->route('Home');
            } elseif (Auth::user()->user_type == 3) {
                session()->flash('success', 'Welcome ' . Auth::user()->name);
                return redirect()->route('Home');
            }
        } else {
            session()->flash('error', 'Sorry! Try Again. It seems your login credential is not correct.');
            return redirect()->back();
        }
    }
    public function postRegister(Request $request)
    {
        if ($request->user_type == 2) {
            $request->validate([
                'name'        => 'required',
                'email'           => 'email|required',
                'password'        => 'required',
                'confPass' => 'required|same:password',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'phone'           => 'required',
                'birth_date'           => 'required',
                'specialty'          => 'required',
                'user_type'          => 'required',
                'fees'          => 'required',
            ]);
        } else {
            $request->validate([
                'name'        => 'required',
                'email'           => 'email|required',
                'password'        => 'required',
                'confPass' => 'required|same:password',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                'phone'           => 'required',
                'birth_date'           => 'required',
                'user_type'          => 'required',
            ]);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->gender = $request->gender;
        $user->birth_date = $request->birth_date;
        $user->phone = $request->phone;
        $user->user_type = $request->user_type;
        //upload user avatar
        if ($request->hasFile('avatar')) {
            $user->avatar = Storage::disk('public')->put('upload/avatars', $request->file('avatar'));
        }
        $user->save();
        if ($user->user_type == 2) {
            $doctor = new Doctor();
            $doctor->bio = $request->bio;
            $doctor->fees = $request->fees;
            $doctor->user_id = $user->id;
            $doctor->specialty_id = $request->specialty;
            $doctor->save();
        }
        $address = new Address();
        $address->city = $request->city;
        $address->state = $request->state;
        $address->postal_code = $request->postal_code;
        $address->user_id = $user->id;
        $address->save();

        return redirect()->route('Login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('Login');
    }
    public function search(Request $request)
    {
        $search = $request->get('search');
        $state = $request->get('states');
        $specialty = $request->get('specialty');
        $allDoctors = User::where('name', 'like', '%' . $search . '%')
            ->where('user_type', 2)->with('doctor');
        if ($specialty !== '0') {
            $allDoctors = $allDoctors->whereHas('doctor.specialty', function ($q) use ($specialty) {
                $q->where('name', $specialty);
            });
        }
        if ($state !== '0') {
            $allDoctors = $allDoctors->whereHas('address', function ($s) use ($state) {
                $s->where('state', $state);
            });
        }
        $allDoctors = $allDoctors->paginate(10);
        return view('landing.doctors.all', compact('allDoctors'));
    }
    public function viewUser($id)
    {
        $user = User::findOrFail($id);
        $allSpecialties = Specialty::get();
        return view('dashboard.user.view', compact('user', 'allSpecialties'));
    }
    public function userProfile($id)
    {
        $user = User::findOrFail($id);
        $allSpecialties = Specialty::all();
        $docTimeSlots = TimeSlot::where('doc_id', $id)->get();
        $docAppointments = Appointment::where('doc_id', $id)->get();
        $userAppointments = Appointment::where('pat_id', $id)->get();
        if ($user->user_type == 2) {
            return view('landing.profile.profile', compact('user', 'docTimeSlots', 'docAppointments'));
        } else {
            return view('landing.profile.profile', compact('user', 'docTimeSlots', 'userAppointments'));
        }
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $allSpecialties = Specialty::all();

        if (Auth::user()->user_type == 2) {
            $doc_id = Doctor::where('user_id', $id)->firstOrFail();
            return view('landing.profile.edit', compact('user', 'doc_id', 'allSpecialties'));
        } elseif (Auth::user()->user_type == 3) {
            return view('landing.profile.edit', compact('user', 'allSpecialties'));
        }
    }

    public function update(Request $request, User $user)
    {
        $input = $request->except('_token', '_method');
        if ($request->filled('password') != '') {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = $user->password;
        }
        $user->phone = $input['phone'];
        $user->gender = $input['gender'];
        $user->birth_date = $input['birth_date'];
        //upload user avatar
        if ($request->hasFile('avatar')) {
            $user->avatar = Storage::disk('public')->put('upload/avatars', $request->file('avatar'));
        }
        //Address
        $user->address->city = $input['city'];
        $user->address->state = $input['state'];
        $user->address->postal_code = $input['postal_code'];

        if ($user->user_type == 1) {
            $user->update($input);
            $user->address->update($input);

            return redirect()->route('AdminProfile');
        } elseif ($user->user_type == 2) {

            $user->doctor->bio = $input['bio'];
            $user->doctor->specialty_id = $input['specialty'];
            $user->doctor->user_id = $user->id;

            $user->update($input);
            $user->address->update($input);
            $user->doctor->update($input);

            return redirect()->route('ViewUser', $user->id);
        } else {
            $user->update($input);
            $user->address->update($input);

            return redirect()->route('ViewUser', $user->id);
        }
    }
    public function updateInfo(Request $request, User $user)
    {
        $input = $request->except('_token', '_method');
        if ($request->filled('password') != '') {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = $user->password;
        }
        $user->phone = $input['phone'];
        $user->gender = $input['gender'];
        $user->birth_date = $input['birth_date'];
        //upload user avatar
        if ($request->hasFile('avatar')) {
            $user->avatar = Storage::disk('public')->put('upload/avatars', $request->file('avatar'));
        }
        //Address
        $user->address->city = $input['city'];
        $user->address->state = $input['state'];
        $user->address->postal_code = $input['postal_code'];
        if (Auth::user()->user_type == 2) {
            dd($request);
            $user->doctor->bio = $input['bio'];
            $user->doctor->specialty_id = $input['specialty'];
            $user->doctor->user_id = $user->id;

            $user->update($input);
            $user->address->update($input);
            $user->doctor->update($input);

            return redirect()->route('UserProfile', $user->id);
        } elseif (Auth::user()->user_type == 3) {
            $user->update($input);
            $user->address->update($input);

            return redirect()->route('UserProfile', $user->id);
        }
    }
    //Admin
    public function userCount()
    {
        $doctors = User::where('user_type', 2)->get();
        $patients = User::where('user_type', 3)->get();
        $appointments = Appointment::get();
        $recentAppointments = Appointment::orderBy('day', 'DESC')->take(10)->get();
        return view('dashboard.index', compact('appointments', 'doctors', 'patients', 'recentAppointments'));
    }
}
