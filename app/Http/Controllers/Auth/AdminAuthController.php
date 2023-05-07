<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function post_login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            session()->flash('error', 'Sorry! Try Again. It seems your login credential is not correct.');
            return redirect()->back();
        }
        $credentials = request(['email', 'password']);
        if (!auth('admin')->attempt($credentials)) {
            notify()->error('Oops, Invalid Credentials.');
            return redirect()->back();
        } else {
            $admin = auth('admin')->user();
            notify()->success('You are awesome, Welcome' . $admin->name);
            return redirect()->route('Dashboard');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('Login');
    }
}
