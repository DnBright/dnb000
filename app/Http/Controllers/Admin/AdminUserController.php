<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.customers', compact('users'));
    }

    public function create()
    {
        return view('admin.customers-create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:32',
            'alamat' => 'nullable|string|max:1024',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['no_hp'] ?? '',
            'address' => $data['alamat'] ?? '',
            'email' => $data['email'],
            'password' => isset($data['password']) ? Hash::make($data['password']) : Hash::make(str()->random(10)),
        ]);

        return redirect()->route('admin.customers')->with('success', 'Customer created');
    }

    public function edit(User $user)
    {
        return view('admin.customers-edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'no_hp' => 'nullable|string|max:32',
            'alamat' => 'nullable|string|max:1024',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $data['name'];
        $user->phone = $data['no_hp'] ?? $user->phone ?? '';
        $user->address = $data['alamat'] ?? $user->address ?? '';
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('admin.customers')->with('success', 'Customer updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.customers')->with('success', 'Customer deleted');
    }
}
