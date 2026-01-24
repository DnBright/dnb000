<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DesignPackage;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin Dark and Bright',
            'email' => 'admin@darkandbright.com',
            'password' => bcrypt('admin123'),
            'phone' => '+62812345678',
            'address' => 'Jakarta, Indonesia',
            'role' => 'admin',
        ]);

        // Create Customer Users
        $customer1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => bcrypt('password123'),
            'phone' => '+62811111111',
            'address' => 'Jakarta, Indonesia',
            'role' => 'customer',
        ]);

        $customer2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => bcrypt('password123'),
            'phone' => '+62822222222',
            'address' => 'Surabaya, Indonesia',
            'role' => 'customer',
        ]);

        $customer3 = User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@example.com',
            'password' => bcrypt('password123'),
            'phone' => '+62833333333',
            'address' => 'Bandung, Indonesia',
            'role' => 'customer',
        ]);

        // Create Design Packages (Exactly 6 as per UI)
        $logoPackage = DesignPackage::create([
            'name' => 'Logo Design',
            'description' => 'Membuat logo profesional sesuai brand Anda',
            'price' => 5000000,
            'category' => 'logo-design',
            'delivery_days' => 7,
            'status' => 'active',
        ]);

        $stationeryPackage = DesignPackage::create([
            'name' => 'Desain Stationery',
            'description' => 'Kartu nama, kop surat, & kebutuhan kantor',
            'price' => 4500000,
            'category' => 'desain-stationery',
            'delivery_days' => 5,
            'status' => 'active',
        ]);

        $webPackage = DesignPackage::create([
            'name' => 'Website Design',
            'description' => 'UI/UX & landing page modern',
            'price' => 25000000,
            'category' => 'website-design',
            'delivery_days' => 21,
            'status' => 'active',
        ]);

        $packagingPackage = DesignPackage::create([
            'name' => 'Kemasan Design',
            'description' => 'Packaging kreatif & menarik',
            'price' => 2500000,
            'category' => 'kemasan-design',
            'delivery_days' => 10,
            'status' => 'active',
        ]);

        $feedPackage = DesignPackage::create([
            'name' => 'Feed Design',
            'description' => 'Desain konten feed & sosial media',
            'price' => 500000,
            'category' => 'feed-design',
            'delivery_days' => 3,
            'status' => 'active',
        ]);

        $otherPackage = DesignPackage::create([
            'name' => 'Design Lainnya',
            'description' => 'Banner, poster, & material lainnya',
            'price' => 750000,
            'category' => 'design-lainnya',
            'delivery_days' => 3,
            'status' => 'active',
        ]);

        // Create Sample Orders
        $order1 = Order::create([
            'customer_id' => $customer1->user_id,
            'package_id' => $logoPackage->package_id,
            'admin_id' => $admin->user_id,
            'brief_text' => 'Kami membutuhkan logo untuk startup fintech with tema modern minimalis',
            'due_date' => now()->addDays(7),
            'status' => 'in_progress',
        ]);

        $order2 = Order::create([
            'customer_id' => $customer2->user_id,
            'package_id' => $webPackage->package_id,
            'admin_id' => $admin->user_id,
            'brief_text' => 'Website e-commerce with fitur marketplace for 100+ vendors',
            'due_date' => now()->addDays(21),
            'status' => 'submitted',
        ]);

        $order3 = Order::create([
            'customer_id' => $customer3->user_id,
            'package_id' => $otherPackage->package_id,
            'admin_id' => $admin->user_id,
            'brief_text' => 'Desain poster for event komunitas',
            'due_date' => now()->addDays(5),
            'status' => 'completed',
        ]);

        // Create Sample Payments
        Payment::create([
            'order_id' => $order1->order_id,
            'amount' => 5000000,
            'method' => 'transfer_bank',
            'status' => 'paid',
            'timestamp' => now(),
        ]);

        Payment::create([
            'order_id' => $order2->order_id,
            'amount' => 12500000,
            'method' => 'transfer_bank',
            'status' => 'pending',
            'timestamp' => now(),
        ]);

        Payment::create([
            'order_id' => $order3->order_id,
            'amount' => 750000,
            'method' => 'transfer_bank',
            'status' => 'paid',
            'timestamp' => now(),
        ]);

        // Call other seeders
        $this->call(\Database\Seeders\HomePageSeeder::class);
        $this->call(\Database\Seeders\FakeOrdersSeeder::class);
    }
}
