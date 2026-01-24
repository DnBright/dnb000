<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminReport extends Model
{
    protected $table = 'adminreport';
    protected $primaryKey = 'report_id';
    public $timestamps = false;

    protected $fillable = [
        'most_popular_package',
        'total_orders',
        'revenue',
        'completed_orders',
        'refund_count',
        'date_generated',
    ];

    protected $dates = [
        'date_generated',
    ];

    protected $casts = [
        'revenue' => 'decimal:2',
    ];

    // Scope untuk get report by date
    public function scopeByDate($query, $date)
    {
        return $query->where('date_generated', $date);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('date_generated', 'desc');
    }
}
