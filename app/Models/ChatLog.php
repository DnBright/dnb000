<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    protected $table = 'chatlog';
    protected $primaryKey = 'chat_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'sender_id',
        'receiver_id',
        'message',
        'file_attachment',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    // Relasi: Chat terkait dengan satu order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Relasi: Chat dikirim oleh satu user (pengirim)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    // Relasi: Chat diterima oleh satu user (penerima)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'user_id');
    }
}
