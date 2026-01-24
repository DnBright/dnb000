<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FakeOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'logo-design', 'website', 'branding', 'seo', 'social-media', 'packaging', 'stationery'
        ];

        // ensure there are some users
        if (User::count() < 5) {
            $needed = 5 - User::count();
            for ($u = 0; $u < $needed; $u++) {
                $email = 'seed+' . uniqid() . '@example.test';
                User::create([
                    'name' => fake()->name(),
                    'email' => $email,
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                    'password' => bcrypt('password'),
                    'role' => 'customer',
                ]);
            }
        }

        $userIds = User::where('role', 'customer')->pluck('user_id')->all();
        $packageIds = \App\Models\DesignPackage::pluck('package_id')->all();
        $adminId = User::where('role', 'admin')->first()->user_id ?? 1;

        $statuses = ['submitted', 'in_progress', 'completed', 'cancelled'];

        for ($i = 0; $i < 50; $i++) {
            $packageId = $packageIds[array_rand($packageIds)];
            $status = $statuses[array_rand($statuses)];

            $createdAt = Carbon::now()->subDays(rand(0, 180))->subHours(rand(0,23))->subMinutes(rand(0,59));
            $deadline = (clone $createdAt)->addDays(rand(3, 30));

            Order::create([
                'customer_id' => $userIds[array_rand($userIds)],
                'package_id' => $packageId,
                'admin_id' => $adminId,
                'brief_text' => fake()->sentence(8),
                'due_date' => $deadline,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
