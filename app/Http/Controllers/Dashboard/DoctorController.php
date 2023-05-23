<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Validator;
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
        $user = User::findOrFail($id);
        return view('dashboard.doctor.edit', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allSpecialties = Specialty::get();
        return view('dashboard.doctor.add', compact('allSpecialties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'specialty_id' => 'required|exits:specialties,id',
            'password' => 'required|string|confirmed'
        ]);

        if ($validation->fails()) {
            session()->flash('error', 'Sorry! Try Again.' . $validation->errors()->first());
            return redirect()->back();
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type' => '1',
            'password' => Hash::make($request->password),
        ]);
        if ($user->user_type == 0) {
            DoctorInfo::create([
                'user_id' => $user->id,
                'specialty_id' => $request->specialty_id,
                'bio' => 'Don’t fear any illness…everything has its cure.',
                'fees' => 0,
            ]);
        }
        notify()->success('You are awesome, The Doctor account has been created successfull!');
        return redirect()->route('patients.index');
    }

    /**
     * Show the form for search about specified resource.
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $allDoctors = User::where('name', 'like', '%' . $search . '%')->where('user_type', 2)->paginate(10);
        return view('dashboard.user.doctors', compact('allDoctors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = User::findOrFail($id);
        $doctor->delete();

        return redirect()->route('Doctors')->with('success', 'Done');
    }
}
