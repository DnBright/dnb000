<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = 'revision';
    protected $primaryKey = 'revision_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'admin_id',
        'revision_no',
        'request_note',
        'revision_file',
        'created_at',
        'resolved_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    // Relasi: Revision terkait dengan satu order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Relasi: Revision ditangani oleh satu admin (user)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }
}
