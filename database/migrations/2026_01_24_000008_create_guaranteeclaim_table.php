<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk tabel GUARANTEECLAIM
     * Mengelola klaim garansi atau jaminan layanan dari customer
     */
    public function up(): void
    {
        Schema::create('guaranteeclaim', function (Blueprint $table) {
            $table->id('claim_id');
            $table->foreignId('order_id')->constrained('order', 'order_id')->onDelete('cascade'); // FK ke order
            $table->foreignId('customer_id')->constrained('users', 'user_id')->onDelete('cascade'); // Customer yang klaim
            $table->text('reason');                         // Alasan klaim (tidak sesuai, cacat, dll)
            $table->dateTime('created_at');                 // Waktu klaim dibuat
            $table->dateTime('resolved_at')->nullable();    // Waktu klaim diselesaikan
            $table->enum('status', ['pending', 'approved', 'rejected', 'refunded'])->default('pending'); // Status klaim
            
            // Indexes
            $table->index('order_id');
            $table->index('customer_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guaranteeclaim');
    }
};
