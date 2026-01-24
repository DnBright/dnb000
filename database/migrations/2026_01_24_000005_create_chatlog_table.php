<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk tabel CHATLOG
     * Mencatat komunikasi antara admin dan customer untuk setiap order
     */
    public function up(): void
    {
        Schema::create('chatlog', function (Blueprint $table) {
            $table->id('chat_id');
            $table->foreignId('order_id')->constrained('order', 'order_id')->onDelete('cascade'); // FK ke order
            $table->foreignId('sender_id')->constrained('users', 'user_id')->onDelete('cascade'); // Siapa pengirim (customer/admin)
            $table->foreignId('receiver_id')->constrained('users', 'user_id')->onDelete('cascade'); // Siapa penerima
            $table->text('message');                        // Isi pesan
            $table->string('attachment', 255)->nullable();  // File attachment (design draft, etc)
            $table->dateTime('timestamp');                  // Waktu pesan
            
            // Indexes
            $table->index('order_id');
            $table->index('sender_id');
            $table->index('receiver_id');
            $table->index('timestamp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatlog');
    }
};
