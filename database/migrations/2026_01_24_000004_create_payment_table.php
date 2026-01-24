<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk tabel PAYMENT
     * Mencatat transaksi pembayaran untuk setiap order
     */
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('order_id')->constrained('order', 'order_id')->onDelete('cascade'); // FK ke order
            $table->decimal('amount', 10, 2);               // Jumlah pembayaran (Rp)
            $table->string('method', 50);                   // Metode pembayaran (credit_card, bank_transfer, e_wallet, etc)
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])->default('pending'); // Status pembayaran
            $table->string('proof', 255)->nullable();       // Bukti pembayaran (screenshot, reference number)
            $table->dateTime('timestamp');                  // Waktu transaksi
            
            // Indexes
            $table->index('order_id');
            $table->index('status');
            $table->index('timestamp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
