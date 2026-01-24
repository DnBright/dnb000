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
                    'nama' => fake()->name(),
                    'email' => $email,
                    'no_hp' => fake()->phoneNumber(),
                    'alamat' => fake()->address(),
                    'password' => bcrypt('password'),
                ]);
            }
        }

        $userIds = User::pluck('id')->all();

        $statuses = ['pending', 'in_progress', 'success', 'cancel'];

        for ($i = 0; $i < 50; $i++) {
            $service = $services[array_rand($services)];
            $amount = rand(150000, 5000000);
            $status = $statuses[array_rand($statuses)];

            $createdAt = Carbon::now()->subDays(rand(0, 180))->subHours(rand(0,23))->subMinutes(rand(0,59));
            $deadline = (clone $createdAt)->addDays(rand(3, 30));

            $notes = fake()->sentence(8);

            Order::create([
                'user_id' => $userIds[array_rand($userIds)],
                'service' => $service,
                'deadline' => $deadline,
                'status' => $status,
                'amount' => $amount,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
