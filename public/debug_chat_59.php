<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<pre>";
$orderId = 59;
$order = \App\Models\Order::find($orderId);

if ($order) {
    echo "Order Found:\n";
    echo "ID: " . $order->order_id . "\n";
    echo "Customer ID: " . $order->customer_id . "\n";
    echo "Admin ID: " . ($order->admin_id ?? 'NULL') . "\n";
    echo "Status: " . $order->status . "\n\n";

    $chats = $order->chats()->with('sender', 'receiver')->get();
    echo "Chat Logs (" . $chats->count() . "):\n";
    foreach ($chats as $chat) {
        echo "ID: " . $chat->chat_id . " | From: " . ($chat->sender->name ?? 'Unknown') . " (" . ($chat->sender->role ?? '?') . ") | To: " . ($chat->receiver->name ?? 'Unknown') . " (" . ($chat->receiver->role ?? '?') . ") | Msg: " . $chat->message . " | Time: " . $chat->timestamp . "\n";
    }
} else {
    echo "Order $orderId NOT found in database.";
}
echo "</pre>";
