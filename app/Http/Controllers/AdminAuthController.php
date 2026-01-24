<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Try normal bcrypt attempt
        try {
            if (Auth::guard('admin')->attempt(array_merge($credentials, ['role' => 'admin']))) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }
        } catch (\RuntimeException $e) {
            \Illuminate\Support\Facades\Log::warning('Admin auth attempt threw RuntimeException (likely legacy hash)', ['email' => $request->email, 'err' => $e->getMessage()]);
            // fall through to legacy fallback below
        }

        // Legacy fallback: check md5/sha1/plain stored passwords and re-hash to bcrypt
        $admin = User::where('email', $request->email)->where('role', 'admin')->first();
        if ($admin) {
            $plain = $request->password;
            $stored = $admin->password;

            $legacyMatch = false;
            if (hash('sha1', $plain) === $stored) $legacyMatch = true;
            if (hash('md5', $plain) === $stored) $legacyMatch = true;
            if ($plain === $stored) $legacyMatch = true;

            if ($legacyMatch) {
                $admin->password = \Illuminate\Support\Facades\Hash::make($plain);
                $admin->save();

                Auth::guard('admin')->login($admin);
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
