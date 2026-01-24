<?php
// Script to find latest pending order and simulate Midtrans settlement notification
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap the framework
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\PaymentWebhookController;

$order = Order::where('status', 'pending')->latest()->first();
if (! $order) {
    echo "NO_PENDING_ORDER\n";
    exit(0);
}

$now = time();
$payload = [
    'order_id' => 'DNB-' . $order->id . '-' . $now,
    'transaction_status' => 'settlement',
    'status_code' => '200',
    'gross_amount' => (int) $order->amount,
    // signature_key omitted for local testing
];

echo "Found order: id={$order->id}, amount={$order->amount}\n";

$request = new Request($payload);
$controller = new PaymentWebhookController();
$response = $controller->notification($request);

echo "Webhook response: ";
if ($response instanceof \Illuminate\Http\JsonResponse) {
    echo json_encode($response->getData(true)) . "\n";
} else {
    echo "OK\n";
}

// Reload order
$order->refresh();
echo "After webhook: status={$order->status}, payment_status={$order->payment_status}\n";
