<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DesignDelivered;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    /**
     * Show printable report of orders.
     */
    public function report(Request $request)
    {
        $query = Order::latest();

        // Optional filtering can be added here
        if ($request->has('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->has('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $orders = $query->get();
        return view('admin.orders.report', compact('orders'));
    }

    /**
     * Display a single order in admin.
     */
    public function show(Order $order)
    {
        return view('admin.order_show', compact('order'));
    }

    /**
     * Fetch chat messages for an order (admin)
     */
    public function chatFetch(Order $order)
    {
        $chats = $order->chats()->with('sender')->orderBy('timestamp', 'asc')->get();

        return response()->json([
            'chats' => $chats->map(function($c) {
                return [
                    'sender' => $c->sender->role === 'admin' ? 'admin' : 'user',
                    'sender_name' => $c->sender->name,
                    'message' => $c->message,
                    'attachment' => $c->file_attachment,
                    'created_at' => $c->timestamp,
                ];
            })
        ]);
    }

    /**
     * Admin sends message to user (from admin dashboard)
     */
    public function chatSend(Request $request, Order $order)
    {
        $data = $request->validate([
            'message' => 'required_without:attachment|string|max:2000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip,rar|max:10240',
        ]);

        $adminId = auth()->id();
        $receiverId = $order->customer_id;

        $msgData = [
            'order_id' => $order->order_id,
            'sender_id' => $adminId,
            'receiver_id' => $receiverId,
            'message' => $data['message'] ?? '',
            'timestamp' => now(),
        ];

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store("orders/{$order->order_id}/chats", 'public');
            $msgData['file_attachment'] = $path;
        }

        $chat = \App\Models\ChatLog::create($msgData);

        return response()->json(['ok' => true, 'msg' => $chat]);
    }

    /**
     * Admin uploads a response file for a user's revision request.
     */
    public function receiveRevisionFile(Request $request, Order $order)
    {
        $data = $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,zip,rar|max:10240',
            'notes' => 'nullable|string'
        ]);

        $path = $request->file('file')->store("orders/{$order->order_id}/revisions", 'public');

        \App\Models\Revision::create([
            'order_id' => $order->order_id,
            'admin_id' => auth()->id(),
            'revision_notes' => $data['notes'] ?? 'Revision response from admin',
            'revision_file' => $path,
            'revision_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Revision response uploaded.');
    }

    /**
     * Update order status from admin dashboard.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|string|in:submitted,in_progress,revision,completed,cancelled'
        ]);

        $order->status = $data['status'];
        $order->save();

        return redirect()->back()->with('success', 'Order status updated.');
    }

    /**
     * Update payment status manually from admin.
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'payment_status' => 'required|string|in:pending,paid,failed',
        ]);

        // Find or create a payment record
        $payment = $order->payments()->first();
        if ($payment) {
            $payment->update(['status' => $data['payment_status']]);
        } else {
            \App\Models\Payment::create([
                'order_id' => $order->order_id,
                'amount' => $order->package->price ?? 0,
                'method' => 'manual',
                'status' => $data['payment_status'],
                'timestamp' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Payment status updated.');
    }

    public function invoice(Order $order)
    {
        $amount = (int) ($order->package->price ?? 0);
        $terbilang = terbilang($amount) . ' RUPIAH';
        
        $dp = 0; 
        $sisa = $amount - $dp;

        return view('admin.invoice', compact('order', 'terbilang', 'dp', 'sisa'));
    }

    /**
     * Export orders as CSV download.
     */
    public function export(Request $request)
    {
        $fileName = 'orders_export_' . date('Ymd_His') . '.csv';
        $orders = Order::orderBy('order_id', 'desc')->with(['customer', 'package'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($orders) {
            $out = fopen('php://output', 'w');
            // header row
            fputcsv($out, ['order_id','customer_id','customer_name','package','status','price','due_date','created_at','updated_at']);

            foreach ($orders as $o) {
                fputcsv($out, [
                    $o->order_id,
                    $o->customer_id,
                    $o->customer->name ?? 'Unknown',
                    $o->package->name ?? 'Generic',
                    $o->status,
                    $o->package->price ?? 0,
                    $o->due_date,
                    $o->created_at,
                    $o->updated_at,
                ]);
            }

            fclose($out);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }

    /**
     * Upload final design file and mark order as delivered.
     */
    public function deliver(Request $request, Order $order)
    {
        $data = $request->validate([
            'final' => 'required|file|mimes:zip,rar,pdf,jpg,jpeg,png,svg|max:10240',
            'notify' => 'nullable|boolean'
        ]);

        $file = $request->file('final');
        $path = $file->store("orders/{$order->order_id}/final", 'public');

        \App\Models\FinalFile::create([
            'order_id' => $order->order_id,
            'file_path' => $path,
            'upload_date' => now(),
            'file_type' => $file->getClientOriginalExtension(),
        ]);

        $order->status = Order::STATUS_COMPLETED;
        $order->save();

        if ($request->boolean('notify')) {
            $to = $order->customer->email ?? null;
            if ($to) {
                try {
                    $url = asset('storage/' . $path);
                    $attachment = storage_path('app/public/' . $path);
                    Mail::to($to)->send(new \App\Mail\DesignDelivered($order, $url, $attachment));
                } catch (\Exception $e) {
                    // ignore mail failure
                }
            }
        }

        return redirect()->back()->with('success', 'Final design uploaded and order marked as completed.');
    }

}