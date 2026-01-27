<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>Midtrans Config Debugger</h1>";
echo "MIDTRANS_PRODUCTION (env): " . var_export(env('MIDTRANS_PRODUCTION'), true) . "<br>";
echo "midtrans.production (config): " . var_export(config('midtrans.production'), true) . "<br>";
echo "Server Key Prefix: " . substr(config('midtrans.server_key'), 0, 5) . "*****<br>";

if (config('midtrans.production')) {
    echo "<h3>Mode: PRODUCTION (Correct)</h3>";
} else {
    echo "<h3 style='color:red'>Mode: SANDBOX (Incorrect)</h3>";
}
