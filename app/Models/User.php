<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ========== RELATIONSHIPS ==========

    // Relasi: Customer memiliki banyak orders
    public function customerOrders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'user_id');
    }

    // Relasi: Admin memiliki banyak orders yang ditangani
    public function adminOrders()
    {
        return $this->hasMany(Order::class, 'admin_id', 'user_id');
    }

    // Relasi: User bisa mengirim banyak chat messages
    public function sentChats()
    {
        return $this->hasMany(ChatLog::class, 'sender_id', 'user_id');
    }

    // Relasi: User bisa menerima banyak chat messages
    public function receivedChats()
    {
        return $this->hasMany(ChatLog::class, 'receiver_id', 'user_id');
    }

    // Relasi: Admin menangani banyak revisions
    public function revisions()
    {
        return $this->hasMany(Revision::class, 'admin_id', 'user_id');
    }

    // Helper methods
    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
