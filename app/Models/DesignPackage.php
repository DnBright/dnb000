<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignPackage extends Model
{
    protected $table = 'designpackage';
    protected $primaryKey = 'package_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'delivery_days',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relasi: Satu paket memiliki banyak order
    public function orders()
    {
        return $this->hasMany(Order::class, 'package_id', 'package_id');
    }
}
