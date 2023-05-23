<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allPatients = User::where('user_type', '1')->paginate(10);
        return view('dashboard.patient.manage', compact('allPatients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.patient.add');
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
            'password' => 'required|string|confirmed'
        ]);

        if ($validation->fails()) {
            session()->flash('error', 'Sorry! Try Again.' . $validation->errors()->first());
            return redirect()->back();
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type' => '1',
            'password' => Hash::make($request->password),
        ]);

        notify()->success('You are awesome, The Doctor account has been created successfull!');
        return redirect()->route('patients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.patient.edit', compact('user'));
    }

    /**
     * Show the form for search about specified resource.
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $allPatients = User::where('name', 'like', '%' . $search . '%')->where('user_type', 3)->paginate(10);
        return view('dashboard.user.patients', compact('allPatients'));
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
        $patient = User::findOrFail($id);
        $patient->delete();
        return redirect()->route('Patients')->with('success', 'Done');
    }
}
