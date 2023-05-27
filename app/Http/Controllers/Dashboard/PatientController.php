<?php

namespace App\Http\Controllers\Dashboard;

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
        return view('dashboard.patient.create');
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
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type' => '1',
            'password' => Hash::make($request->password),
        ]);

        notify()->success('You are awesome, The Patient account has been created successfull!');
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
        $allPatients = User::where('name', 'like', '%' . $search . '%')->where('user_type', '1')->paginate(10);
        return view('dashboard.patient.manage', compact('allPatients'));
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
            ]);

            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            if (!empty($request->password)) {
                $request->validate([
                    'password' => 'sometimes|required',
                    'confirm_password' => 'sometimes|required|same:password'
                ]);
                $user->password = Hash::make($request->password);
            }
            $user->save();
            notify()->success('You are awesome, The Patient account has been created successfull!');
            return redirect()->route('patients.index');
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
        $patient = User::find($id);
        if ($patient) {
            $patient->delete();
            notify()->success('You are awesome, The Patient account has been deleted successfull!');
        } else {
            notify()->error('Opps!, The Patient account has been deleted before');
        }
        return redirect()->back();
    }
}
