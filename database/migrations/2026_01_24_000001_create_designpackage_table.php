<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration untuk tabel DESIGNPACKAGE
     * Menyimpan katalog paket/layanan desain yang ditawarkan
     */
    public function up(): void
    {
        Schema::create('designpackage', function (Blueprint $table) {
            $table->id('package_id');
            $table->string('name', 255);                    // Nama paket (Logo Design, Website Design, dll)
            $table->text('description')->nullable();        // Deskripsi detail paket
            $table->decimal('price', 10, 2);                // Harga paket dalam Rupiah
            $table->string('category', 100);                // Kategori (logo, website, packaging, etc)
            $table->integer('delivery_days');               // Jumlah hari pengerjaan
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status paket
            $table->timestamps();
            
            // Indexes untuk query optimization
            $table->index('category');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designpackage');
    }
};
