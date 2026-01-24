<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalFile extends Model
{
    protected $table = 'finalfile';
    protected $primaryKey = 'file_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'file_path',
        'upload_date',
        'file_type',
    ];

    protected $dates = [
        'upload_date',
    ];

    // Relasi: File terkait dengan satu order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
