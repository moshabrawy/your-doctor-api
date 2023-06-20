<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoctorInfo;
use App\Models\Specialty;
use App\Models\User;

class DoctorController extends Controller
{
    public function index()
    {
        $allDoctors = User::where('user_type', '0')->paginate(10);
        return view('dashboard.doctor.manage', compact('allDoctors'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        $allSpecialties = Specialty::get();
        return view('dashboard.doctor.edit', compact('user', 'allSpecialties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allSpecialties = Specialty::get();
        return view('dashboard.doctor.create', compact('allSpecialties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'specialty_id' => 'required|exists:specialties,id',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type' => '0',
            'password' => Hash::make($request->password),
        ]);
        DoctorInfo::create([
            'user_id' => $user->id,
            'specialty_id' => $request->specialty_id,
            'bio' => 'Don’t fear any illness…everything has its cure.',
            'fees' => 0,
        ]);
        notify()->success('You are awesome, The Doctor account has been created successfull!');
        return redirect()->route('doctors.index');
    }

    /**
     * Show the form for search about specified resource.
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $allDoctors = User::where('name', 'like', '%' . $search . '%')->where('user_type', "0")->paginate(10);
        return view('dashboard.doctor.manage', compact('allDoctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $request->validate([
                'name' => 'sometimes|required|string',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
                'phone' => 'sometimes|required|unique:users,phone,' . $user->id,
                'specialty_id' => 'sometimes|required|exists:specialties,id'
            ]);

            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            if ($request->has('password')) {
                $request->validate([
                    'password' => 'required',
                    'confirm_password' => 'required|same:password'
                ]);
                $user->password = Hash::make($request->password);
            }
            if (!empty($request->specialty_id)) {
                $user->doctor_info->specialty_id = $request->specialty_id ?? $user->doctor_info->specialty_id;
            }
            $user->save();
            notify()->success('You are awesome, The Doctor account has been created successfull!');
            return redirect()->route('doctors.index');
        } else {
            notify()->error('Opps!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = User::find($id);
        if ($doctor) {
            $doctor->delete();
            notify()->success('You are awesome, The Doctor account has been deleted successfull!');
        } else {
            notify()->error('Opps!, The Doctor account has been deleted before');
        }
        return redirect()->back();
    }
}
