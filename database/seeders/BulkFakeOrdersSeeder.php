<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BulkFakeOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'logo-design', 'website', 'branding', 'seo', 'social-media', 'packaging', 'stationery', 'illustration', 'ads', 'ux-ui'
        ];

        // Ensure there are some users available
        if (User::count() < 10) {
            $needed = 10 - User::count();
            for ($u = 0; $u < $needed; $u++) {
                User::create([
                    'name' => fake()->name(),
                    'email' => 'seed+' . uniqid() . '@example.test',
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

        $count = 600;
        for ($i = 0; $i < $count; $i++) {
            $packageId = $packageIds[array_rand($packageIds)];
            $status = $statuses[array_rand($statuses)];

            // spread created_at over the past 12 months
            $monthsBack = rand(0, 11);
            $createdAt = Carbon::now()->subMonths($monthsBack)->subDays(rand(0, 27))->subHours(rand(0, 23))->subMinutes(rand(0,59));
            $deadline = (clone $createdAt)->addDays(rand(3, 60));

            Order::create([
                'customer_id' => $userIds[array_rand($userIds)],
                'package_id' => $packageId,
                'admin_id' => $adminId,
                'brief_text' => fake()->sentence(10),
                'due_date' => $deadline,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
