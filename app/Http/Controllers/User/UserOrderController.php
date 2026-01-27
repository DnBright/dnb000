<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class UserOrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('customer_id', $user->user_id)->with(['package', 'payments'])->latest()->get();

        return view('user.orders', compact('orders'));
    }

    /**
     * Return minimal JSON for live updates.
     */
    public function updates(Request $request)
    {
        $user = Auth::user();
        $orders = Order::where('customer_id', $user->user_id)
            ->with(['package', 'payments', 'finalFiles'])
            ->orderBy('order_id', 'desc')
            ->get();
        
        $payload = $orders->map(function($o){
            $isPaid = $o->payments()->where('status', 'paid')->exists();
            $finalFile = $o->finalFiles->last();
            return [
                'id' => $o->order_id,
                'status' => $o->status,
                'payment_status' => $isPaid ? 'success' : 'pending',
                'amount' => (int) ($o->package->price ?? 0),
                'updated_at' => $o->updated_at,
                'final_file' => $finalFile ? $finalFile->file_path : null,
            ];
        });

        return response()->json(['orders' => $payload]);
    }

    /**
     * Show revision request form for a single order.
     */
    public function showRevision(Order $order)
    {
        $user = Auth::user();
        if ((int)$order->customer_id !== (int)$user->user_id) abort(403);

        $revisions = $order->revisions()->orderBy('created_at', 'desc')->get();

        return view('user.revision', compact('order','revisions'));
    }

    /**
     * Handle revision submission from user.
     */
    public function submitRevision(Request $request, Order $order)
    {
        $user = Auth::user();
        if ((int)$order->customer_id !== (int)$user->user_id) abort(403);

        $data = $request->validate([
            'notes' => 'required|string|max:2000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip,rar|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store("orders/{$order->order_id}/revisions", 'public');
        }

        $revisionNo = \App\Models\Revision::where('order_id', $order->order_id)->count() + 1;

        \App\Models\Revision::create([
            'order_id' => $order->order_id,
            'admin_id' => $order->admin_id,
            'revision_no' => $revisionNo,
            'request_note' => $data['notes'],
            'revision_file' => $path,
            'created_at' => now(),
        ]);

        if (in_array($order->status, ['submitted', 'in_progress', 'completed'])) {
            $order->status = 'revision';
        }
        $order->save();

        return redirect()->route('user.orders')->with('success', 'Permintaan revisi telah dikirim.');
    }

    /**
     * Fetch chat messages for an order (user)
     */
    public function chatFetch(Order $order)
    {
        $user = Auth::user();
        if ($order->customer_id !== $user->user_id) abort(403);

        $chats = $order->chats()->with('sender')->orderBy('timestamp', 'asc')->get();

        return response()->json([
            'chats' => $chats->map(function($c) {
                return [
                    'sender' => $c->sender->role ?? 'user',
                    'sender_name' => $c->sender->name ?? 'User',
                    'message' => $c->message,
                    'attachment' => $c->attachment,
                    'created_at' => $c->timestamp,
                ];
            })
        ]);
    }

    /**
     * Send a chat message from user to admin for an order
     */
    public function chatSend(Request $request, Order $order)
    {
        $user = Auth::user();
        if ($order->customer_id !== $user->user_id) abort(403);
        
        $data = $request->validate([
            'message' => 'required_without:attachment|string|max:2000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip,rar|max:10240',
        ]);

        $msgData = [
            'order_id' => $order->order_id,
            'sender_id' => $user->user_id,
            'receiver_id' => $order->admin_id ?? 1, // Fallback to main admin
            'message' => $data['message'] ?? '',
            'timestamp' => now(),
        ];

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store("orders/{$order->order_id}/chats", 'public');
            $msgData['attachment'] = $path;
        }

        $chat = \App\Models\ChatLog::create($msgData);

        return response()->json(['ok' => true, 'msg' => $chat]);
    }

    /**
     * Cancel an order by the owner (user).
     */
    /**
     * Cancel an order by the owner (user).
     */
    public function cancel(Request $request, $id)
    {
        $user = Auth::user();
        $order = Order::findOrFail($id);
        
        if ($order->customer_id != $user->user_id) abort(403);

        if ($order->status === 'completed' || $order->payments()->where('status', 'paid')->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat membatalkan order yang sudah selesai atau terbayar.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('user.orders')->with('success', 'Order berhasil dibatalkan.');
    }

    /**
     * Delete an order belonging to the user (only non-successful orders).
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $order = Order::findOrFail($id);
        
        if ($order->customer_id != $user->user_id) abort(403);

        if ($order->status === 'completed') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus order yang sudah selesai.');
        }

        // Relationships auto-deleted if cascade is set, but we handle files here
        try {
            foreach ($order->finalFiles as $f) {
                Storage::disk('public')->delete($f->file_path);
            }
            foreach ($order->revisions as $r) {
                if ($r->revision_file) Storage::disk('public')->delete($r->revision_file);
            }
            foreach ($order->chats as $c) {
                if ($c->attachment) Storage::disk('public')->delete($c->attachment);
            }
        } catch (\Exception $e) {}

        $order->delete();

        return redirect()->route('user.orders')->with('success', 'Order berhasil dihapus.');
    }

    /**
     * PRIVATE: Sync order status from Midtrans API.
     */
    private function syncOrder(Order $order)
    {
        $meta = $order->meta ?? [];
        $midtransId = $meta['midtrans_order_id'] ?? null;
        if (!$midtransId) return false;

        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.production', false);
        $baseUrl = $isProduction ? 'https://api.midtrans.com/v2/' : 'https://api.sandbox.midtrans.com/v2/';
        $endpoint = $baseUrl . $midtransId . '/status';

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($endpoint, [
                'auth' => [$serverKey, ''],
                'verify' => config('midtrans.verify', false),
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);

            $body = json_decode((string) $response->getBody(), true);
            $txStatus = $body['transaction_status'] ?? null;

            if ($txStatus) {
                // set payment_status based on transaction result
                if (in_array($txStatus, ['capture','settlement'])) {
                    $order->payment_status = 'success';
                } elseif (in_array($txStatus, ['deny', 'cancel', 'expire'])) {
                    $order->payment_status = 'cancel';
                } else {
                    $order->payment_status = 'pending';
                }

                $order->meta = array_merge($order->meta ?? [], ['last_sync' => now()->toDateTimeString(), 'midtrans_status' => $body]);
                $order->save();
                return true;
            }
        } catch (\Exception $e) {
            \Log::warning('Midtrans sync failed for Order ' . $order->order_id, ['error' => $e->getMessage()]);
        }
        return false;
    }

    /**
     * Show formal invoice (printable).
     */
    /**
     * Show formal invoice (printable).
     */
    public function printInvoice(Order $order)
    {
        $user = Auth::user();
        if ($order->customer_id !== $user->user_id) abort(403);

        $amount = (int) ($order->package->price ?? 0);
        $terbilang = $this->terbilang($amount) . ' Rupiah';

        $dp = 0; 
        $sisa = $amount - $dp;

        return view('user.invoice', compact('order', 'terbilang', 'dp', 'sisa'));
    }

    private function terbilang($nilai) {
        $nilai = abs($nilai);
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->terbilang($nilai - 10). " Belas";
        } else if ($nilai < 100) {
            $temp = $this->terbilang($nilai/10)." Puluh". $this->terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . $this->terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->terbilang($nilai/100) . " Ratus" . $this->terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . $this->terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->terbilang($nilai/1000) . " Ribu" . $this->terbilang($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->terbilang($nilai/1000000) . " Juta" . $this->terbilang($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->terbilang($nilai/1000000000) . " Milyar" . $this->terbilang(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->terbilang($nilai/1000000000000) . " Trilyun" . $this->terbilang(fmod($nilai,1000000000000));
        }
        return $temp;
    }
}
