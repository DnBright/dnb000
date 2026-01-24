<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
$orders = Order::orderBy('updated_at','desc')->limit(20)->get(['id','status','payment_status','amount','updated_at']);
foreach($orders as $o) {
    echo sprintf("%4d | %-8s | %-8s | %10s | %s\n", $o->id, $o->status, $o->payment_status ?? 'NULL', $o->amount, $o->updated_at);
}
