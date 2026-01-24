<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function notification(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans webhook received', ['payload' => $payload]);

        if (empty($payload['order_id'])) {
            return response()->json(['error' => 'Missing order_id'], 400);
        }

        // Extract numeric payment id from order_id (DNB-PAY-{payment_id}-{ts})
        if (preg_match('/DNB-PAY-(\d+)-/', $payload['order_id'], $m)) {
            $paymentId = (int) $m[1];
        } else {
            // fallback: check if it's the old format DNB-{order_id}-{ts}
            if (preg_match('/DNB-(\d+)-/', $payload['order_id'], $m)) {
                 $oldOrderId = (int) $m[1];
                 // search by payment proof
                 $payment = \App\Models\Payment::where('proof', $payload['order_id'])->first();
            }
            $paymentId = $payment->payment_id ?? null;
        }

        $payment = $payment ?? \App\Models\Payment::find($paymentId);

        if (!$payment) {
            Log::warning('Midtrans webhook: payment record not found', ['received_order_id' => $payload['order_id'], 'payload' => $payload]);
            return response()->json(['error' => 'Payment record not found'], 404);
        }

        $txStatus = $payload['transaction_status'] ?? strtolower($payload['status'] ?? '');

        // set payment status based on transaction result
        if (in_array($txStatus, ['capture', 'settlement'])) {
            $payment->status = 'paid';
        } elseif (in_array($txStatus, ['deny', 'cancel', 'expire'])) {
            $payment->status = 'failed';
        } else {
            $payment->status = 'pending';
        }

        $payment->save();

        // Optionally update the order status if needed
        if ($payment->status === 'paid') {
            $order = $payment->order;
            if ($order && $order->status === 'submitted') {
                $order->status = 'in_progress';
                $order->save();
            }
        }

        Log::info('Midtrans webhook processed', ['payment_id' => $payment->payment_id, 'status' => $payment->status]);

        return response()->json(['ok' => true]);
    }
}
