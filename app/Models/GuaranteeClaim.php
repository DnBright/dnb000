<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuaranteeClaim extends Model
{
    protected $table = 'guaranteeclaim';
    protected $primaryKey = 'claim_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'customer_id',
        'reason',
        'created_at',
        'resolved_at',
        'status',
    ];

    protected $dates = [
        'created_at',
        'resolved_at',
    ];

    // Constants untuk status claim
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_REFUNDED = 'refunded';

    // Relasi: Claim terkait dengan satu order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Relasi: Claim dibuat oleh satu customer (user)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'user_id');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function markAsApproved()
    {
        $this->update(['status' => self::STATUS_APPROVED, 'resolved_at' => now()]);
    }

    public function markAsRejected()
    {
        $this->update(['status' => self::STATUS_REJECTED, 'resolved_at' => now()]);
    }

    public function markAsRefunded()
    {
        $this->update(['status' => self::STATUS_REFUNDED, 'resolved_at' => now()]);
    }
}
