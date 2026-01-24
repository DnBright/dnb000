<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DesignDelivered extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $url;
    public ?string $attachmentPath = null;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $url, ?string $attachmentPath = null)
    {
        $this->order = $order;
        $this->url = $url;
        $this->attachmentPath = $attachmentPath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $m = $this->subject("Your design is ready - Order #{$this->order->order_id}")
                  ->view('emails.design_delivered')
                  ->with([
                      'order' => $this->order,
                      'url' => $this->url,
                  ]);

        if ($this->attachmentPath && file_exists($this->attachmentPath)) {
            try {
                $m->attach($this->attachmentPath, [
                    'as' => basename($this->attachmentPath),
                ]);
            } catch (\Exception $e) {
                // ignore attach failures
            }
        }

        return $m;
    }
}
