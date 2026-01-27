<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>User Auth Debug</h1>";

$user = Auth::user();

if (!$user) {
    echo "<h2 style='color:red'>NOT LOGGED IN</h2>";
    echo "Please login first at: <a href='/login'>/login</a>";
    exit;
}

echo "<h2>Current Logged In User:</h2>";
echo "<strong>User ID:</strong> " . $user->id . "<br>";
echo "<strong>Name:</strong> " . $user->name . "<br>";
echo "<strong>Email:</strong> " . $user->email . "<br>";

echo "<hr>";

echo "<h2>Orders for this User (customer_id = {$user->id}):</h2>";

$orders = \App\Models\Order::where('customer_id', $user->id)
    ->with(['package', 'payments'])
    ->latest()
    ->get();

echo "<strong>Total Orders Found:</strong> " . $orders->count() . "<br><br>";

foreach ($orders as $o) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";
    echo "<strong>Order ID:</strong> " . $o->order_id . "<br>";
    echo "<strong>Package:</strong> " . ($o->package->name ?? 'NULL') . "<br>";
    echo "<strong>Status:</strong> " . $o->status . "<br>";
    echo "<strong>Created:</strong> " . $o->created_at . "<br>";
    echo "</div>";
}

if ($orders->count() === 0) {
    echo "<h3 style='color:orange'>No orders found for user ID {$user->id}</h3>";
    echo "<p>Check if orders in database have different customer_id</p>";
}
