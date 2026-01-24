<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk tabel FINALFILE
     * Menyimpan file hasil desain final yang siap dikirim ke customer
     */
    public function up(): void
    {
        Schema::create('finalfile', function (Blueprint $table) {
            $table->id('file_id');
            $table->foreignId('order_id')->constrained('order', 'order_id')->onDelete('cascade'); // FK ke order
            $table->string('file_path', 255);               // Path file di storage
            $table->string('file_type', 50);                // Tipe file (pdf, png, jpg, psd, etc)
            $table->enum('file_type_category', ['source', 'final', 'backup'])->default('final'); // Kategori file
            $table->dateTime('uploaded_at')->useCurrent();                // Waktu upload file
            
            // Indexes
            $table->index('order_id');
            $table->index('file_type');
            $table->index('uploaded_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finalfile');
    }
};
