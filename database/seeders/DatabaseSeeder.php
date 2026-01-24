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

        // Create Design Packages
        $logoPackage = DesignPackage::create([
            'name' => 'Logo Design',
            'description' => 'Desain logo profesional untuk brand Anda dengan berbagai konsep dan revisi unlimited',
            'price' => 5000000,
            'category' => 'logo',
            'delivery_days' => 7,
            'status' => 'active',
        ]);

        $webPackage = DesignPackage::create([
            'name' => 'Website Design',
            'description' => 'Desain website responsif dan modern dengan UI/UX terbaik',
            'price' => 25000000,
            'category' => 'website',
            'delivery_days' => 21,
            'status' => 'active',
        ]);

        $printPackage = DesignPackage::create([
            'name' => 'Print Design',
            'description' => 'Desain cetak profesional (brochure, flyer, business card, dll)',
            'price' => 3000000,
            'category' => 'print',
            'delivery_days' => 5,
            'status' => 'active',
        ]);

        $brandingPackage = DesignPackage::create([
            'name' => 'Complete Branding',
            'description' => 'Paket lengkap branding termasuk logo, guidelines, dan materials',
            'price' => 50000000,
            'category' => 'branding',
            'delivery_days' => 30,
            'status' => 'active',
        ]);

        // Create Sample Orders
        $order1 = Order::create([
            'customer_id' => $customer1->user_id,
            'package_id' => $logoPackage->package_id,
            'admin_id' => $admin->user_id,
            'brief_text' => 'Kami membutuhkan logo untuk startup fintech dengan tema modern dan minimalis',
            'due_date' => now()->addDays(7),
            'status' => 'in_progress',
        ]);

        $order2 = Order::create([
            'customer_id' => $customer2->user_id,
            'package_id' => $webPackage->package_id,
            'admin_id' => $admin->user_id,
            'brief_text' => 'Website e-commerce dengan fitur marketplace untuk 100+ vendors',
            'due_date' => now()->addDays(21),
            'status' => 'submitted',
        ]);

        $order3 = Order::create([
            'customer_id' => $customer3->user_id,
            'package_id' => $printPackage->package_id,
            'admin_id' => $admin->user_id,
            'brief_text' => 'Desain brochure A4 untuk perusahaan property developer',
            'due_date' => now()->addDays(5),
            'status' => 'completed',
        ]);

        // Create Sample Payments
        Payment::create([
            'order_id' => $order1->order_id,
            'amount' => 5000000,
            'method' => 'transfer_bank',
            'status' => 'paid',
        ]);

        Payment::create([
            'order_id' => $order2->order_id,
            'amount' => 12500000,
            'method' => 'transfer_bank',
            'status' => 'pending',
        ]);

        Payment::create([
            'order_id' => $order3->order_id,
            'amount' => 3000000,
            'method' => 'transfer_bank',
            'status' => 'paid',
        ]);

        // Call other seeders
        $this->call(\Database\Seeders\HomePageSeeder::class);
        $this->call(\Database\Seeders\FakeOrdersSeeder::class);
    }
}
