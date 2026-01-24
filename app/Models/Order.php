<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'package_id',
        'admin_id',
        'brief_text',
        'brief_file',
        'due_date',
        'status',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Constants untuk status order sesuai ERD
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REVISION = 'revision';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // ========== RELATIONSHIPS ==========

    // Relasi: Order milik satu customer (user)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'user_id');
    }

    // Relasi: Order menggunakan satu design package
    public function package()
    {
        return $this->belongsTo(DesignPackage::class, 'package_id', 'package_id');
    }

    // Relasi: Order ditangani oleh satu admin (user dengan role admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }

    // Relasi: Order memiliki banyak payments
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'order_id');
    }

    // Relasi: Order memiliki banyak chat logs
    public function chats()
    {
        return $this->hasMany(ChatLog::class, 'order_id', 'order_id');
    }

    // Relasi: Order memiliki banyak revisions
    public function revisions()
    {
        return $this->hasMany(Revision::class, 'order_id', 'order_id');
    }

    // Relasi: Order memiliki banyak final files
    public function finalFiles()
    {
        return $this->hasMany(FinalFile::class, 'order_id', 'order_id');
    }

    // Relasi: Order bisa memiliki satu guarantee claim
    public function guaranteeClaim()
    {
        return $this->hasOne(GuaranteeClaim::class, 'order_id', 'order_id');
    }

    // ========== HELPER METHODS ==========

    public function markAsInProgress()
    {
        $this->update(['status' => self::STATUS_IN_PROGRESS]);
    }

    public function markAsRevision()
    {
        $this->update(['status' => self::STATUS_REVISION]);
    }

    public function markAsCompleted()
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
    }

    public function markAsCancelled()
    {
        $this->update(['status' => self::STATUS_CANCELLED]);
    }
}
