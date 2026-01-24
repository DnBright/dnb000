<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk tabel USERS
     * Menyimpan informasi pelanggan sistem
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name', 255);                    // Nama pelanggan
            $table->string('email', 255)->unique();         // Email unik
            $table->string('password', 255);                // Password terenkripsi
            $table->string('phone', 50)->nullable();        // Nomor telepon/WhatsApp
            $table->text('address')->nullable();            // Alamat lengkap
            $table->enum('role', ['customer', 'admin'])->default('customer'); // Role user
            $table->timestamps();
            
            // Indexes
            $table->index('email');
            $table->index('role');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
