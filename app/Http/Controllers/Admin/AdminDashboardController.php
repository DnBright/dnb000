<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Arr;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // contoh data / ambil dari DB
        $totalEarnings = Order::where('status', 'paid')->sum('amount') ?? 12450;
        $activeOrders = Order::whereIn('status', ['in_progress', 'pending'])->count() ?? 24;
        $impressions = 45200;
        $rating = 4.9;

        // data tren / grafik (bulan)
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        // contoh revenue per bulan (sesuaikan dengan data asli jika ada)
        $revenues = [1200, 1500, 1800, 2200, 2400, 2600, 3000, 2800, 3100, 3300, 3500, 3700];

        // recent orders untuk tabel
        $recentOrders = Order::latest()->take(8)->get();

        // contoh top services (dummy jika tidak ada data tersendiri)
        $topServices = [
            ['title' => 'Logo Design', 'sales' => 120, 'revenue' => 4200, 'change' => 12],
            ['title' => 'Website Development', 'sales' => 85, 'revenue' => 10250, 'change' => 8],
            ['title' => 'SEO Optimization', 'sales' => 60, 'revenue' => 5400, 'change' => -3],
        ];

        return view('admin.dashboard', compact(
            'totalEarnings',
            'activeOrders',
            'impressions',
            'rating',
            'months',
            'revenues',
            'recentOrders',
            'topServices'
        ));
    }
}
