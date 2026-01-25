<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BriefController extends Controller
{
    public function review(Request $request)
    {
        $data = $request->all();

        // simpan session agar GET bisa ambil data
        session(['reviewData' => $data]);
        
        // simpan paket jika ada di request
        if ($request->has('paket')) {
            session(['selectedPaket' => $request->input('paket')]);
        }

        return redirect()->route('review.show');
    }

    public function show()
    {
        $data = session('reviewData');
        $paket = session('selectedPaket', 'standard');

        return view('review', compact('data', 'paket'));
    }

    public function checkout()
    {
        $data = session('reviewData');
        $paket = session('selectedPaket', 'standard');

        if (empty($data)) {
            return redirect()->route('brief.show', $paket)->with('error', 'Data brief tidak ditemukan.');
        }

        // Fetch package from database to get package_id
        $package = \App\Models\DesignPackage::where('status', 'active')
            ->where(function($q) use ($paket) {
                $q->where('name', 'LIKE', str_replace('-', ' ', $paket))
                  ->orWhere('category', 'LIKE', $paket);
            })->first();

        // Fallback for ID if not found by name
        $packageId = $package->package_id ?? 1; // Assuming 1 is a safe default or generic bucket

        $order = \App\Models\Order::create([
            'customer_id' => auth()->id(),
            'package_id' => $packageId,
            'status' => 'submitted',
            'due_date' => now()->addDays((int)($package->delivery_days ?? 7)),
        ]);

        session(['order_id' => $order->order_id]);

        return redirect()->route('payment.show', ['order' => $order->order_id]);
    }

    public function paymentShow(\App\Models\Order $order)
    {
        $data = session('reviewData', []);
        return view('payment', compact('order', 'data'));
    }
}
