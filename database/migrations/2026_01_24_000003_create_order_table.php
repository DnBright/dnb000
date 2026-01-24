<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk tabel ORDER
     * Menyimpan pesanan dari pelanggan
     */
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('customer_id')->constrained('users', 'user_id')->onDelete('cascade'); // FK ke users
            $table->foreignId('package_id')->constrained('designpackage', 'package_id')->onDelete('restrict'); // FK ke designpackage
            $table->foreignId('admin_id')->nullable()->constrained('users', 'user_id')->onDelete('set null'); // Admin yang handle
            $table->text('brief_text')->nullable();         // Brief dari klien (detail project)
            $table->string('brief_file', 255)->nullable();  // File brief (PDF, doc, etc)
            $table->dateTime('due_date');                   // Deadline pengerjaan
            $table->enum('status', ['submitted', 'in_progress', 'revision', 'completed', 'cancelled'])->default('submitted'); // Status order
            $table->timestamps();
            
            // Indexes
            $table->index('customer_id');
            $table->index('admin_id');
            $table->index('package_id');
            $table->index('status');
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
