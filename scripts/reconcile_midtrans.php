<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

$config = require __DIR__ . '/../config/midtrans.php';
$serverKey = $config['server_key'] ?? getenv('MIDTRANS_SERVER_KEY');
$isProd = $config['production'] ?? false;
$base = $isProd ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com';

$pending = Order::where(function($q){
    $q->whereNull('payment_status')->orWhere('payment_status','<>','success');
})->whereRaw("JSON_EXTRACT(meta, '$.midtrans_order_id') IS NOT NULL")->get();

if ($pending->isEmpty()) {
    echo "No pending orders with midtrans_order_id\n";
    exit(0);
}

$client = new Client(['auth' => [$serverKey, ''], 'headers' => ['Accept' => 'application/json'], 'verify' => false]);

foreach ($pending as $order) {
    $midId = $order->meta['midtrans_order_id'] ?? null;
    if (! $midId) continue;
    echo "Checking order {$order->id} -> {$midId}\n";
    try {
        $resp = $client->get($base . '/v2/' . urlencode($midId) . '/status');
        $body = json_decode((string)$resp->getBody(), true);
        $tx = $body['transaction_status'] ?? strtolower($body['status'] ?? '');
        $map = [
            'capture' => 'success',
            'settlement' => 'success',
            'pending' => 'pending',
            'deny' => 'cancel',
            'cancel' => 'cancel',
            'expire' => 'cancel',
        ];
        $newStatus = $map[$tx] ?? ($body['status_message'] ?? 'pending');
        $order->status = $newStatus;
        if (in_array($tx, ['capture','settlement'])) {
            $order->payment_status = \App\Models\Order::PAYMENT_SUCCESS;
        }
        $order->meta = array_merge($order->meta ?? [], ['midtrans_reconcile' => $body]);
        $order->save();
        echo "Updated order {$order->id} => status={$order->status}, payment_status={$order->payment_status}\n";
    } catch (\Exception $e) {
        echo "Failed to check {$order->id}: " . $e->getMessage() . "\n";
        Log::warning('Reconcile midtrans failed', ['order' => $order->id, 'err' => $e->getMessage()]);
    }
}
