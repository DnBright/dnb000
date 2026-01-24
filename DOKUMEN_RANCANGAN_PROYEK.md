# Dokumen Rancangan Tugas Proyek Digital Bisnis
## Laporan Implementasi Sistem Informasi "Dark and Bright"

**Proyek:** Dark and Bright (Premium Design Agency Platform)  
**Tahun:** 2026  
**Domain:** [darknb.com](http://darknb.com)  

---

## Ringkasan Eksekutif

Laporan ini menyajikan hasil dokumentasi lengkap perancangan dan implementasi proyek digital bisnis **Dark and Bright**. Fokus utama proyek ini adalah menyediakan platform jasa desain kreatif yang profesional dengan integrasi proses bisnis yang mulus antara pelanggan dan administrasi. Dokumen ini mencakup arsitektur basis data yang kokoh, visualisasi antarmuka produk, serta strategi teknis implementasi dan hosting.

---

## A. Hasil Implementasi Rancangan Database

Sistem basis data dirancang untuk mendukung skalabilitas dan integritas transaksi tinggi. Pendekatan relasional digunakan untuk memastikan setiap poin data mulai dari identitas pengguna hingga status distribusi file terkelola secara akurat.

### 1. Arsitektur Relasi (Entity Relationship Diagram)
Basis data terdiri dari 9 entitas utama yang saling berhubungan untuk membentuk alur kerja agensi desain yang koheren.

![ERD Database](/Users/mac/.gemini/antigravity/brain/dcae6b62-1915-4e80-846b-5e748f4719da/uploaded_image_1769188456719.png)

### 2. Deskripsi Modul Basis Data (Penjelasan Tabel)

Kami mengimplementasikan skema database MySQL dengan struktur teknis sebagai berikut:

*   **Manajemen Pengguna & Akses:**
    *   **`user`**: Merupakan entitas pusat untuk otentikasi. Membedakan tingkatan akses melalui kolom `role` (Admin/Customer).
    ```sql
    CREATE TABLE `user` (
      `user_id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) UNIQUE NOT NULL,
      `password` varchar(255) NOT NULL,
      `role` enum('customer', 'admin') DEFAULT 'customer'
    );
    ```

*   **Manajemen Paket & Transaksi:**
    *   **`designpackage`**: Menyimpan katalog produk layanan kreatif.
    *   **`order`**: Tabel operasional yang mencatat pesanan masuk, referensi desain, dan tenggat waktu.
    *   **`payment`**: Mengelola verifikasi transaksi keuangan dan integrasi payment gateway.
    ```sql
    CREATE TABLE `order` (
      `order_id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `customer_id` int(11) NOT NULL,
      `package_id` int(11) NOT NULL,
      `status` enum('pending', 'in_progress', 'completed') DEFAULT 'pending',
      FOREIGN KEY (`customer_id`) REFERENCES `user`(`user_id`)
    );
    ```

*   **Modul Interaksi & Kualitas:**
    *   **`chatlog`**: Mendokumentasikan komunikasi pesanan secara real-time.
    *   **`revision`**: Sistem kontrol perubahan untuk menjamin kepuasan pelanggan.
    *   **`finalfile`**: Pusat penyimpanan artefak digital hasil akhir.
    *   **`guaranteeclaim`**: Modul mitigasi risiko dan layanan purna jual.

*   **Modul Analitik:**
    *   **`adminreport`**: Tabel agregat untuk monitoring performa bisnis bulanan.

### 3. Implementasi pada Framework Laravel
Guna memastikan konsistensi antara desain database dan aplikasi web, kami menggunakan Laravel Migrations sebagai alat standardisasi skema:

```php
// Contoh Implementasi Migration untuk Pesanan
Schema::create('orders', function (Blueprint $table) {
    $table->id('order_id');
    $table->foreignId('customer_id')->constrained('user', 'user_id')->onDelete('cascade');
    $table->enum('order_status', ['submitted', 'processing', 'finalized']);
    $table->timestamp('due_date');
    $table->timestamps();
});
```

---

## B. Hasil Implementasi Produk Digital

Implementasi produk dilakukan dengan fokus pada *User Experience* (UX) yang modern, menggunakan tema visual "Dark & Bright" untuk mempertegas identitas agensi kreatif.

### 1. Front-End Presence (Landing Page & Portfolio)
![Landing Page](/Users/mac/.gemini/antigravity/brain/dcae6b62-1915-4e80-846b-5e748f4719da/landing_page_1769188605208.png)
*   **Analisis UI/UX:** Antarmuka menggunakan *dark mode* premium untuk memberikan fokus pada portfolio visual.
*   **Logika Bisnis:** Informasi paket layanan ditarik secara dinamis dari tabel `designpackage`. Hal ini memudahkan admin memperbarui harga atau kategori desain melalui dashboard.

![Portfolio](/Users/mac/.gemini/antigravity/brain/dcae6b62-1915-4e80-846b-5e748f4719da/portfolio_page_1769188664951.png)
*   **Fungsionalitas:** Menampilkan hasil karya nyata yang bersumber dari entitas `finalfile` yang telah dipublikasikan, memberikan bukti sosial kepada calon pelanggan.

### 2. Alur Transaksi (Paket & Checkout)
![Paket Page](/Users/mac/.gemini/antigravity/brain/dcae6b62-1915-4e80-846b-5e748f4719da/paket_page_1769188686921.png)
*   **Proses Bisnis:** Pelanggan memilih paket yang tervalidasi pada database. Setiap pemilihan akan menginisiasi record pada tabel `order` dan memicu mekanisme notifikasi ke sistem administrasi.
*   **Integrasi Data:** Validasi harga pesanan dilakukan di sisi server (*server-side*) dengan mencocokkan ID paket pada tabel `designpackage` untuk mencegah manipulasi data.

### 3. Back-End Management (Admin Dashboard)
![Admin Login](/Users/mac/.gemini/antigravity/brain/dcae6b62-1915-4e80-846b-5e748f4719da/admin_login_page_1769188707573.png)
*   **Kontrol Operasional:** Melalui dashboard ini, admin mengelola seluruh aliran data:
    *   Verifikasi pembayaran (Tabel `payment`).
    *   Manajemen komunikasi desain (Tabel `chatlog`).
    *   Pengunggahan hulu produk (Tabel `finalfile`).
*   **Keamanan:** Menggunakan proteksi *middleware* Laravel untuk memastikan hanya pengguna dengan `role='admin'` dari tabel `user` yang dapat mengakses modul ini.

---

## C. Link Produk & Strategi Hosting

Keberlanjutan operasional produk digital didukung oleh infrastruktur yang aman dan terukur.

### 1. Publikasi Website
*   **Primary Domain:** [http://darknb.com](http://darknb.com)
*   **Status Aplikasi:** *Ready for Deployment* (Tahap Produksi Akhir).

### 2. Strategi Deployment
*   **Infrastruktur:** Rencana penggunaan Cloud VPS dengan konfigurasi Ubuntu Server + Nginx.
*   **Database:** Setup MySQL 8.0 dengan sistem backup harian otomatis.
*   **Keamanan:** Implementasi SSL via Let's Encrypt serta integrasi Midtrans untuk keamanan transaksi finansial.

---

## Kesimpulan

Proyek digital bisnis **Dark and Bright** telah memenuhi seluruh kriteria rancangan mulai dari arsitektur backend hingga estetika frontend. Integrasi antara 9 tabel database yang kompleks dengan fungsionalitas produk digital memastikan bahwa operasional bisnis dapat berjalan secara otomatis, aman, dan profesional. Dokumen ini menjadi acuan utama dalam pengembangan dan pemeliharaan sistem di masa mendatang.

---
*Laporan ini disusun secara profesional untuk memenuhi standar dokumentasi proyek bisnis teknologi informasi.*
