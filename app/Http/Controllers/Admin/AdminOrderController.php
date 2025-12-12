<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    /**
     * Display a single order in admin.
     */
    public function show(Order $order)
    {
        return view('admin.order_show', compact('order'));
    }

}