# DOKUMENTASI DATABASE SESUAI ERD - DARK AND BRIGHT

## Ringkasan Perubahan Database (Dari 5 Tabel → 9 Tabel)

Database telah diperbarui sepenuhnya untuk mengikuti ERD yang Anda rencanakan. Berikut adalah struktur database yang baru dengan 9 tabel utama.

---

## TABEL-TABEL DATABASE BARU

### 1. **DESIGNPACKAGE** - Katalog Layanan Desain

**Fungsi:** Menyimpan daftar paket/layanan yang ditawarkan oleh agensi.

```
designpackage
├── package_id (PK)
├── name (VARCHAR)
├── description (TEXT)
├── price (DECIMAL)
├── category (VARCHAR)
├── delivery_days (INT)
├── status (ENUM: active, inactive)
└── timestamps
```

**Relasi:** 1 package → banyak orders

---

### 2. **USERS** - Manajemen Pengguna (Customer & Admin)

**Fungsi:** Menyimpan data customer dan admin dalam satu tabel dengan role-based access.

```
users
├── user_id (PK)
├── name (VARCHAR)
├── email (VARCHAR, UNIQUE)
├── password (VARCHAR)
├── phone (VARCHAR)
├── address (TEXT)
├── role (ENUM: customer, admin)
└── timestamps
```

**Relasi:**
- 1 user (customer) → banyak orders (sebagai customer_id)
- 1 user (admin) → banyak orders (sebagai admin_id)
- 1 user → banyak chats (sebagai sender atau receiver)
- 1 user (admin) → banyak revisions

---

### 3. **ORDER** - Manajemen Pesanan

**Fungsi:** Mencatat semua pesanan dengan status lifecycle lengkap.

```
order
├── order_id (PK)
├── customer_id (FK → users)
├── package_id (FK → designpackage)
├── admin_id (FK → users, nullable)
├── brief_text (TEXT)
├── brief_file (VARCHAR)
├── created_at (DATETIME)
├── due_date (DATETIME)
├── status (ENUM: submitted, in_progress, revision, completed, cancelled)
└── updated_at
```

**Status Workflow:**
```
submitted → in_progress → revision → completed
           ↓ (if needed)
       completed
       
       ↓ (at any time)
    cancelled
```

**Relasi:**
- Order → customer (belongsTo User)
- Order → package (belongsTo DesignPackage)
- Order → admin (belongsTo User)
- Order ← payments (hasMany Payment)
- Order ← chats (hasMany ChatLog)
- Order ← revisions (hasMany Revision)
- Order ← finalFiles (hasMany FinalFile)
- Order ← guaranteeClaim (hasOne GuaranteeClaim)

---

### 4. **PAYMENT** - Transaksi Pembayaran

**Fungsi:** Mencatat semua transaksi pembayaran untuk setiap order.

```
payment
├── payment_id (PK)
├── order_id (FK → order)
├── amount (DECIMAL)
├── method (VARCHAR)
├── status (ENUM: pending, paid, failed, refunded)
├── proof (VARCHAR)
└── timestamp (DATETIME)
```

**Payment Methods:** credit_card, bank_transfer, e_wallet, etc

**Relasi:** payment → order (belongsTo)

---

### 5. **CHATLOG** - Komunikasi Real-time

**Fungsi:** Mencatat semua pesan antara customer dan admin untuk setiap order.

```
chatlog
├── chat_id (PK)
├── order_id (FK → order)
├── sender_id (FK → users)
├── receiver_id (FK → users)
├── message (TEXT)
├── attachment (VARCHAR)
└── timestamp (DATETIME)
```

**Relasi:**
- chat → order (belongsTo)
- chat → sender (belongsTo User)
- chat → receiver (belongsTo User)

---

### 6. **REVISION** - Kontrol Perubahan Design

**Fungsi:** Mengelola permintaan revisi dan tracking perubahan.

```
revision
├── revision_id (PK)
├── order_id (FK → order)
├── revision_no (INT)
├── request_note (TEXT)
├── admin_id (FK → users)
├── created_at (DATETIME)
└── resolved_at (DATETIME, nullable)
```

**Relasi:**
- revision → order (belongsTo)
- revision → admin (belongsTo User)

---

### 7. **FINALFILE** - Penyimpanan File Hasil

**Fungsi:** Menyimpan file-file hasil desain yang siap diserahkan.

```
finalfile
├── file_id (PK)
├── order_id (FK → order)
├── file_path (VARCHAR)
├── file_type (VARCHAR: pdf, png, jpg, psd, ai, etc)
├── file_type_category (ENUM: source, final, backup)
└── uploaded_at (DATETIME)
```

**File Categories:**
- **source**: PSD, AI, Sketch (file kerja desainer)
- **final**: PNG, PDF, JPG (siap pakai pelanggan)
- **backup**: Arsip backup project

**Relasi:** finalFile → order (belongsTo)

---

### 8. **GUARANTEECLAIM** - Sistem Garansi/Klaim

**Fungsi:** Mengelola klaim/complaint pelanggan terhadap hasil design.

```
guaranteeclaim
├── claim_id (PK)
├── order_id (FK → order)
├── customer_id (FK → users)
├── reason (TEXT)
├── created_at (DATETIME)
├── resolved_at (DATETIME, nullable)
└── status (ENUM: pending, approved, rejected, refunded)
```

**Relasi:**
- claim → order (belongsTo)
- claim → customer (belongsTo User)

---

### 9. **ADMINREPORT** - Laporan Analytics

**Fungsi:** Menyimpan ringkasan laporan untuk admin dashboard.

```
adminreport
├── report_id (PK)
├── most_popular_package (VARCHAR)
├── total_orders (INT)
├── revenue (DECIMAL)
├── completed_orders (INT)
├── refund_count (INT)
└── date_generated (DATE)
```

---

## ENTITY RELATIONSHIP DIAGRAM (ERD) - Struktur Relasi

```
┌────────────────────────────────────────────────────────────────┐
│                         USERS (user_id)                        │
│  ┌─────────────────────────────────────────────────────────┐  │
│  │ user_id (PK) | name | email | password | phone | role   │  │
│  └─────────────────────────────────────────────────────────┘  │
└────────┬────────────────────────────┬─────────────────────────┘
         │ 1:N (customer_id)          │ 1:N (admin_id)
         │                            │
    ┌────▼───────────────┐    ┌──────▼────────────────┐
    │     ORDER           │    │  (handled by admin)   │
    │   (order_id)        │    │                       │
    └────┬───────────────┘    └──────┬────────────────┘
         │ 1:N (order_id)           │ 1:N (order_id)
         │                          │
    ┌────▼─────┐    ┌────▼──────┐   │  ┌────────────┐
    │  PAYMENT  │    │ CHATLOG   │   │  │ REVISION   │
    │(payment_id)    │(chat_id)  │   │  │(revision_id)
    └───────────┘    └───────────┘   │  └────────────┘
                                      │
                    ┌─────────────────┼──────────────┐
                    │                 │              │
                ┌───▼──────┐    ┌────▼────────┐  ┌─▼─────────┐
                │FINALFILE  │    │GUARANTEE    │  │DESIGN     │
                │(file_id)  │    │ CLAIM       │  │PACKAGE    │
                │           │    │(claim_id)   │  │(package_id)
                └───────────┘    └─────────────┘  └───────────┘
                                       │           (1:N)
                                  (1:N order_id)  ↓
                                       │      ORDER
                                       │  (package_id)

DESIGN PACKAGE (package_id)
│ name, description, price, category, delivery_days
└─ 1:N → ORDER (package_id)
   └─ 1:N → PAYMENT (order_id)
   └─ 1:N → CHATLOG (order_id)
   └─ 1:N → REVISION (order_id)
   └─ 1:N → FINALFILE (order_id)
   └─ 1:1 → GUARANTEECLAIM (order_id)
```

---

## MODEL ELOQUENT RELATIONSHIPS

### User Model
```php
public function customerOrders() {
    return $this->hasMany(Order::class, 'customer_id', 'user_id');
}

public function adminOrders() {
    return $this->hasMany(Order::class, 'admin_id', 'user_id');
}

public function sentChats() {
    return $this->hasMany(ChatLog::class, 'sender_id', 'user_id');
}

public function receivedChats() {
    return $this->hasMany(ChatLog::class, 'receiver_id', 'user_id');
}

public function revisions() {
    return $this->hasMany(Revision::class, 'admin_id', 'user_id');
}
```

### Order Model
```php
public function customer() {
    return $this->belongsTo(User::class, 'customer_id', 'user_id');
}

public function package() {
    return $this->belongsTo(DesignPackage::class, 'package_id', 'package_id');
}

public function admin() {
    return $this->belongsTo(User::class, 'admin_id', 'user_id');
}

public function payments() {
    return $this->hasMany(Payment::class, 'order_id', 'order_id');
}

public function chats() {
    return $this->hasMany(ChatLog::class, 'order_id', 'order_id');
}

public function revisions() {
    return $this->hasMany(Revision::class, 'order_id', 'order_id');
}

public function finalFiles() {
    return $this->hasMany(FinalFile::class, 'order_id', 'order_id');
}

public function guaranteeClaim() {
    return $this->hasOne(GuaranteeClaim::class, 'order_id', 'order_id');
}
```

### DesignPackage Model
```php
public function orders() {
    return $this->hasMany(Order::class, 'package_id', 'package_id');
}
```

### Payment Model
```php
public function order() {
    return $this->belongsTo(Order::class, 'order_id', 'order_id');
}
```

### ChatLog Model
```php
public function order() {
    return $this->belongsTo(Order::class, 'order_id', 'order_id');
}

public function sender() {
    return $this->belongsTo(User::class, 'sender_id', 'user_id');
}

public function receiver() {
    return $this->belongsTo(User::class, 'receiver_id', 'user_id');
}
```

### Revision Model
```php
public function order() {
    return $this->belongsTo(Order::class, 'order_id', 'order_id');
}

public function admin() {
    return $this->belongsTo(User::class, 'admin_id', 'user_id');
}
```

### FinalFile Model
```php
public function order() {
    return $this->belongsTo(Order::class, 'order_id', 'order_id');
}
```

### GuaranteeClaim Model
```php
public function order() {
    return $this->belongsTo(Order::class, 'order_id', 'order_id');
}

public function customer() {
    return $this->belongsTo(User::class, 'customer_id', 'user_id');
}
```

### AdminReport Model
```php
// Scope untuk get report by date
public function scopeByDate($query, $date) {
    return $query->where('date_generated', $date);
}

public function scopeLatest($query) {
    return $query->orderBy('date_generated', 'desc');
}
```

---

## CONTOH QUERY MENGGUNAKAN RELATIONSHIPS

### Mendapatkan semua order dari seorang customer
```php
$customer = User::find(1);
$orders = $customer->customerOrders()->get();
// SELECT * FROM order WHERE customer_id = 1
```

### Mendapatkan detail order dengan semua relasi
```php
$order = Order::with([
    'customer',
    'package',
    'admin',
    'payments',
    'chats',
    'revisions',
    'finalFiles',
    'guaranteeClaim'
])->find(1);
```

### Mendapatkan chat untuk satu order
```php
$order = Order::find(1);
$chats = $order->chats()->orderBy('timestamp', 'desc')->get();
```

### Mendapatkan revision yang belum diselesaikan
```php
$order = Order::find(1);
$pendingRevisions = $order->revisions()
    ->whereNull('resolved_at')
    ->get();
```

### Mendapatkan total revenue dari completed orders
```php
$totalRevenue = Order::where('status', 'completed')
    ->join('payment', 'order.order_id', '=', 'payment.order_id')
    ->sum('payment.amount');
```

### Mendapatkan paket paling populer
```php
$mostPopular = Order::select('package_id')
    ->selectRaw('count(*) as order_count')
    ->groupBy('package_id')
    ->orderBy('order_count', 'desc')
    ->first();
```

---

## CARA MENJALANKAN MIGRATIONS

```bash
# Jalankan semua migrations
php artisan migrate

# Jika ada error, rollback dulu
php artisan migrate:rollback

# Refresh database (hapus semua dan buat ulang)
php artisan migrate:refresh

# Seed dummy data (optional)
php artisan db:seed
```

---

## VERIFIKASI DATABASE

Setelah migration berhasil, verifikasi dengan:

```sql
-- Melihat semua tabel
SHOW TABLES;

-- Melihat struktur tabel
DESC users;
DESC order;
DESC designpackage;
DESC payment;
DESC chatlog;
DESC revision;
DESC finalfile;
DESC guaranteeclaim;
DESC adminreport;

-- Melihat foreign keys
SELECT CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'darkandbright' AND COLUMN_NAME LIKE '%_id';
```

---

## MIGRATION FILES YANG DIBUAT

✅ 2026_01_24_000001_create_designpackage_table.php  
✅ 2026_01_24_000002_create_users_table.php  
✅ 2026_01_24_000003_create_order_table.php  
✅ 2026_01_24_000004_create_payment_table.php  
✅ 2026_01_24_000005_create_chatlog_table.php  
✅ 2026_01_24_000006_create_revision_table.php  
✅ 2026_01_24_000007_create_finalfile_table.php  
✅ 2026_01_24_000008_create_guaranteeclaim_table.php  
✅ 2026_01_24_000009_create_adminreport_table.php  

## MODEL FILES YANG DIBUAT/UPDATED

✅ app/Models/DesignPackage.php  
✅ app/Models/User.php (updated)  
✅ app/Models/Order.php (updated)  
✅ app/Models/Payment.php  
✅ app/Models/ChatLog.php  
✅ app/Models/Revision.php  
✅ app/Models/FinalFile.php  
✅ app/Models/GuaranteeClaim.php  
✅ app/Models/AdminReport.php  

---

**Database telah disesuaikan sepenuhnya dengan ERD yang Anda rencanakan!**

Tanggal Update: 24 Januari 2026
