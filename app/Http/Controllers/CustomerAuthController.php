<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login'); // halaman login customer
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login'); // customer login
    }
}
