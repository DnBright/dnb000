<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Order;

class PaymentController extends Controller
{
    public function token(Request $request, Order $order)
    {
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $amount = (int) ($order->package->price ?? 0);
        if ($amount <= 0) {
            return response()->json(['error' => 'Order amount invalid'], 422);
        }

        if ($order->status === Order::STATUS_COMPLETED) {
            return response()->json(['error' => 'Order already completed'], 400);
        }

        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.production', false);
        $endpoint = $isProduction ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // Create a pending payment record first to get a unique identifier
        $payment = \App\Models\Payment::create([
            'order_id' => $order->order_id,
            'amount' => $amount,
            'method' => 'midtrans',
            'status' => 'pending',
            'timestamp' => now(),
        ]);

        $payload = [
            'transaction_details' => [
                'order_id' => 'DNB-PAY-' . $payment->payment_id . '-' . time(),
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $order->customer->name ?? 'Customer',
                'email' => $order->customer->email ?? '',
                'phone' => $order->customer->phone ?? '',
            ],
        ];

        try {
            $client = new Client();
            $verifyConfig = config('midtrans.verify', false);
            $cacertPath = config('midtrans.cacert');

            $options = [
                'auth' => [$serverKey, ''],
                'json' => $payload,
                'headers' => [ 'Accept' => 'application/json' ],
            ];

            if ($verifyConfig) {
                if (!empty($cacertPath) && file_exists($cacertPath)) {
                    $options['verify'] = $cacertPath;
                } else {
                    $options['verify'] = true;
                }
            } else {
                $options['verify'] = false;
            }

            // We store the midtrans order id in the payment proof field for now as a reference
            $payment->update(['proof' => $payload['transaction_details']['order_id']]);

            $response = $client->post($endpoint, $options);
            $body = json_decode((string) $response->getBody(), true);

            return response()->json([
                'token' => $body['token'] ?? null,
                'redirect_url' => $body['redirect_url'] ?? null,
                'client_key' => config('midtrans.client_key'),
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Midtrans request failed', 'message' => $e->getMessage()], 500);
        }
    }
}
