<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk tabel REVISION
     * Mengelola permintaan revisi dan tracking perubahan design
     */
    public function up(): void
    {
        Schema::create('revision', function (Blueprint $table) {
            $table->id('revision_id');
            $table->foreignId('order_id')->constrained('order', 'order_id')->onDelete('cascade'); // FK ke order
            $table->integer('revision_no');                 // Nomor revisi (1, 2, 3, dll)
            $table->text('request_note');                   // Catatan permintaan revisi
            $table->foreignId('admin_id')->constrained('users', 'user_id')->onDelete('cascade'); // Admin yang handle
            $table->dateTime('created_at');                 // Waktu request revisi
            $table->dateTime('resolved_at')->nullable();    // Waktu revisi selesai
            
            // Indexes
            $table->index('order_id');
            $table->index('admin_id');
            $table->index('revision_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revision');
    }
};
