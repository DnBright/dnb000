<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk tabel ADMINREPORT
     * Menyimpan laporan dan analytics untuk admin
     */
    public function up(): void
    {
        Schema::create('adminreport', function (Blueprint $table) {
            $table->id('report_id');
            $table->string('most_popular_package', 255);    // Paket paling populer
            $table->integer('total_orders');                // Total pesanan
            $table->decimal('revenue', 15, 2);              // Total revenue
            $table->integer('completed_orders');            // Jumlah order selesai
            $table->integer('refund_count');                // Jumlah refund
            $table->date('date_generated');                 // Tanggal laporan dibuat
            
            // Indexes
            $table->index('date_generated');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adminreport');
    }
};
