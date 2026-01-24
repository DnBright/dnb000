<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // First, try normal bcrypt authentication
        try {
            if (Auth::guard('admin')->attempt(array_merge($credentials, ['role' => 'admin']))) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil.');
            }
        } catch (\RuntimeException $e) {
            // fall through to legacy fallback below
        }

        // Fallback for legacy passwords (sha1/md5/plain)
        $admin = \App\Models\User::where('email', $request->email)->where('role', 'admin')->first();
        if ($admin) {
            $plain = $request->password;
            $stored = $admin->password;

            $legacyMatch = false;
            // sha1
            if (hash('sha1', $plain) === $stored) $legacyMatch = true;
            // md5
            if (hash('md5', $plain) === $stored) $legacyMatch = true;
            // plain
            if ($plain === $stored) $legacyMatch = true;

            if ($legacyMatch) {
                // Re-hash to bcrypt and login
                $admin->password = \Illuminate\Support\Facades\Hash::make($plain);
                $admin->save();

                Auth::guard('admin')->login($admin);
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil.');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
