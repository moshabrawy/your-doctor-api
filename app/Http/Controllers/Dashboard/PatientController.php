<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function showPatients()
    {
        $allPatients = User::where('user_type', 3)->paginate(10);
        return view('dashboard.user.patients', compact('allPatients'));
    }

    public function regPatient(Request $request)
    {
        $request->validate([
            'pat_name'        => 'required',
            'email'           => 'email|required',
            'password'        => 'required',
            'confirmPassword' => 'required|same:password',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone'           => 'required',
            'gender'          => 'required',
            // 'user_type'       => '3',
        ]);

        $user = new User();
        $user->name = $request->pat_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->gender = $request->gender;
        $user->birth_date = $request->birth_date;
        $user->phone = $request->phone;
        $user->user_type = 3;
        //upload user avatar
        if ($request->hasFile('avatar')) {
            $user->avatar = Storage::disk('public')->put('upload/avatars', $request->file('avatar'));
        }
        $user->save();

        $address = new Address();
        $address->city = $request->city;
        $address->state = $request->state;
        $address->postal_code = $request->postal_code;
        $address->user_id = $user->id;

        $address->save();

        return redirect()->route('Patients');
    }

    public function search(Request $request){
        $search = $request->get('search');
        $allPatients = User::where('name' , 'like', '%'.$search.'%')->where('user_type', 3)->paginate(10);
        return view('dashboard.user.patients', compact('allPatients'));
    }

    public function destroy($id)
    {
        $patient = User::findOrFail($id);
        $patient->delete();
        return redirect()->route('Patients')->with('success', 'Done');
    }
}
