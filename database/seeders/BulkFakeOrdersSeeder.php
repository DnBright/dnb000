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
                    'nama' => fake()->name(),
                    'email' => 'seed+' . uniqid() . '@example.test',
                    'no_hp' => fake()->phoneNumber(),
                    'alamat' => fake()->address(),
                    'password' => bcrypt('password'),
                ]);
            }
        }

        $userIds = User::pluck('id')->all();

        $statuses = ['pending', 'in_progress', 'success', 'cancel'];

        $count = 600;
        for ($i = 0; $i < $count; $i++) {
            $service = $services[array_rand($services)];
            $amount = rand(100000, 5000000); // stored as e.g. 2500000.00
            $status = $statuses[array_rand($statuses)];

            // spread created_at over the past 12 months
            $monthsBack = rand(0, 11);
            $createdAt = Carbon::now()->subMonths($monthsBack)->subDays(rand(0, 27))->subHours(rand(0, 23))->subMinutes(rand(0,59));
            $deadline = (clone $createdAt)->addDays(rand(3, 60));

            Order::create([
                'user_id' => $userIds[array_rand($userIds)],
                'service' => $service,
                'deadline' => $deadline->toDateString(),
                'status' => $status,
                'amount' => $amount,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
