<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>Order Debug</h1>";

$orders = \App\Models\Order::latest()->with(['customer', 'package'])->get();

echo "<h3>Total Orders: " . $orders->count() . "</h3>";

foreach ($orders as $o) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";
    echo "<strong>Order ID:</strong> " . $o->order_id . "<br>";
    echo "<strong>Customer ID:</strong> " . $o->customer_id . "<br>";
    echo "<strong>Customer Name:</strong> " . ($o->customer->name ?? 'NULL - MISSING CUSTOMER') . "<br>";
    echo "<strong>Package ID:</strong> " . $o->package_id . "<br>";
    echo "<strong>Package Name:</strong> " . ($o->package->name ?? 'NULL - MISSING PACKAGE') . "<br>";
    echo "<strong>Status:</strong> " . $o->status . "<br>";
    echo "<strong>Created:</strong> " . $o->created_at . "<br>";
    echo "</div>";
}
