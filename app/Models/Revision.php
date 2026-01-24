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
        'revision_notes',
        'revision_file',
        'revision_date',
    ];

    protected $casts = [
        'revision_date' => 'datetime',
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
