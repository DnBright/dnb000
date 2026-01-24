<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        // Use the existing auth.login view
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // First try normal attempt (wrap because some stored passwords are legacy formats)
        try {
            if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
                return redirect()->route('dashboard')->with('success', 'Login berhasil.');
            }
        } catch (\RuntimeException $e) {
            // BcryptHasher may throw if the stored password isn't a bcrypt hash.
            // Fall through to legacy fallback checks below.
            \Illuminate\Support\Facades\Log::warning('Auth::attempt threw RuntimeException (likely legacy hash)', ['email' => $request->email, 'err' => $e->getMessage()]);
        }

        // Attempt detailed checks and try to migrate legacy hashes
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email atau password salah!');
        }

        $plain = $request->password;
        // If stored password is bcrypt, check and rehash if algorithm changed
        try {
            if (\Illuminate\Support\Facades\Hash::check($plain, $user->password)) {
                // if needs rehash, update
                if (\Illuminate\Support\Facades\Hash::needsRehash($user->password)) {
                    $user->password = Hash::make($plain);
                    $user->save();
                }
                Auth::guard('web')->login($user);
                return redirect()->route('dashboard')->with('success', 'Login berhasil.');
            }
        } catch (\Exception $e) {
            // log the exception for debugging (avoid exposing to user)
            \Illuminate\Support\Facades\Log::warning('Hash check failed for user login', ['email' => $request->email, 'err' => $e->getMessage()]);
        }

        // Plaintext fallback (legacy non-hashed passwords)
        if ($user->password === $plain) {
            $user->password = Hash::make($plain);
            $user->save();
            Auth::guard('web')->login($user);
            return redirect()->route('dashboard')->with('success', 'Login berhasil.');
        }

        // MD5 fallback (legacy)
        if (preg_match('/^[0-9a-f]{32}$/i', $user->password) && md5($plain) === $user->password) {
            $user->password = Hash::make($plain);
            $user->save();
            Auth::guard('web')->login($user);
            return redirect()->route('dashboard')->with('success', 'Login berhasil.');
        }

        // Log failed attempt for debugging
        \Illuminate\Support\Facades\Log::info('Failed login attempt', ['email' => $request->email, 'user_exists' => true]);

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    /**
     * Update authenticated user's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:32',
            'alamat' => 'nullable|string|max:1024',
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->no_hp = $data['no_hp'] ?? $user->no_hp;
        $user->alamat = $data['alamat'] ?? $user->alamat;
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
