<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAuthentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('dashboard.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => ['required', 'email'],
            "password" => ['required', 'string'],
        ]);

        $userLogin = User::where('email', $request->email)->whereIn('role_id', [1, 2])->first();
        if ($userLogin) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect(url('/dashboard/home'));
            }else{
                $request->session()->flash('error-msg', 'credentials not correct');
                return redirect(url('dashboard/login'));
            }
        }else{
            return redirect(url('/'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('admin.login'));
    }
}
