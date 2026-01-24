<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixPlainPasswordsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('password', 'not like', '\\$2y\\$%')->get();
        foreach ($users as $user) {
            $user->password = Hash::make($user->password);
            $user->save();
        }
    }
}
