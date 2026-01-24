# PANDUAN SETUP DATABASE DARK AND BRIGHT

## 📋 Prerequisites

Pastikan sudah memiliki:
- PHP 8.1+
- MySQL 8.0+
- Laravel 11
- Composer
- Git (optional)

---

## 🚀 Installation Steps

### Step 1: Configure Database (.env)

Edit file `.env` di root project:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=darkandbright
DB_USERNAME=root
DB_PASSWORD=your_password
```

**Untuk XAMPP:**
```env
DB_HOST=localhost
DB_USERNAME=root
DB_PASSWORD=
```

**Untuk LAMP Stack:**
```env
DB_HOST=localhost
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Step 2: Create Database (Jika belum ada)

**Menggunakan MySQL CLI:**
```bash
mysql -u root -p
# Masukkan password Anda (atau kosongkan untuk XAMPP)

# Di MySQL console:
CREATE DATABASE darkandbright;
EXIT;
```

**Atau menggunakan PHP:**
```bash
php artisan tinker
DB::statement('CREATE DATABASE IF NOT EXISTS darkandbright');
exit();
```

### Step 3: Install Dependencies

```bash
cd /Users/mac/Downloads/Darkandbright
composer install
```

### Step 4: Generate App Key

```bash
php artisan key:generate
```

### Step 5: Run Migrations

**Opsi A: Jalankan semua migrations**
```bash
php artisan migrate
```

**Opsi B: Jalankan hanya migration ERD terbaru**
```bash
php artisan migrate --path=database/migrations/2026_01_24_*.php
```

**Opsi C: Jalankan dengan rollback dulu (reset)**
```bash
php artisan migrate:reset
php artisan migrate
```

### Step 6: Verify Database

```bash
php artisan tinker

# Check all tables
DB::table('designpackage')->count();
DB::table('users')->count();
DB::table('order')->count();
DB::table('payment')->count();
DB::table('chatlog')->count();
DB::table('revision')->count();
DB::table('finalfile')->count();
DB::table('guaranteeclaim')->count();
DB::table('adminreport')->count();

exit();
```

---

## 📊 Database Structure

### Table Count: 9 Tables

```
✅ designpackage    - Katalog layanan
✅ users            - Customer & Admin
✅ order            - Pesanan
✅ payment          - Pembayaran
✅ chatlog          - Komunikasi
✅ revision         - Kontrol perubahan
✅ finalfile        - File hasil
✅ guaranteeclaim   - Garansi/klaim
✅ adminreport      - Laporan
```

---

## 🔑 Foreign Key Relationships

```
designpackage (1) ──── (N) order
users (1) ──── (N) order (customer_id)
users (1) ──── (N) order (admin_id)
order (1) ──── (N) payment
order (1) ──── (N) chatlog
order (1) ──── (N) revision
order (1) ──── (N) finalfile
order (1) ──── (1) guaranteeclaim
users (1) ──── (N) chatlog (sender)
users (1) ──── (N) chatlog (receiver)
users (1) ──── (N) revision (admin)
users (1) ──── (N) guaranteeclaim (customer)
```

---

## 🛠️ Common Issues & Solutions

### Issue 1: "SQLSTATE[HY000]: General error: 1030 Got error"
**Solution:**
```bash
php artisan migrate:reset
php artisan migrate
```

### Issue 2: "SQLSTATE[42S01]: Base table or view already exists"
**Solution:**
Tabel sudah ada. Gunakan `migrate:fresh`:
```bash
php artisan migrate:fresh
```

### Issue 3: "SQLSTATE[HY000]: General error: 14 unable to open database file"
**Solution:**
Database belum dibuat. Buat database terlebih dahulu:
```bash
mysql -u root -p -e "CREATE DATABASE darkandbright;"
```

### Issue 4: "SQLSTATE[HY000]: General error: 2002 No such file or directory"
**Solution:**
Update host di .env dari `127.0.0.1` menjadi `localhost`:
```env
DB_HOST=localhost
```

---

## 📝 Seed Data (Optional)

### Create Seeder untuk Design Packages

Buat file `database/seeders/DesignPackageSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DesignPackage;

class DesignPackageSeeder extends Seeder
{
    public function run(): void
    {
        DesignPackage::create([
            'name' => 'Logo Design',
            'description' => 'Desain logo profesional dengan 3x revisi',
            'price' => 500000.00,
            'category' => 'logo',
            'delivery_days' => 7,
            'status' => 'active',
        ]);

        DesignPackage::create([
            'name' => 'Website Design',
            'description' => 'Desain UI/UX website responsif dan modern',
            'price' => 2500000.00,
            'category' => 'website',
            'delivery_days' => 14,
            'status' => 'active',
        ]);

        DesignPackage::create([
            'name' => 'Packaging Design',
            'description' => 'Desain kemasan produk menarik dan fungsional',
            'price' => 1000000.00,
            'category' => 'packaging',
            'delivery_days' => 10,
            'status' => 'active',
        ]);

        DesignPackage::create([
            'name' => 'Feed Design',
            'description' => 'Desain konten feed Instagram 5 post',
            'price' => 300000.00,
            'category' => 'feed',
            'delivery_days' => 3,
            'status' => 'active',
        ]);
    }
}
```

### Run Seeder

```bash
php artisan db:seed --class=DesignPackageSeeder
```

---

## 🔍 Verify Installation

### Method 1: Using Artisan Tinker

```bash
php artisan tinker

# Check tables
Schema::hasTable('designpackage'); // true
Schema::hasTable('users'); // true
Schema::hasTable('order'); // true

# Check columns
Schema::hasColumns('order', ['order_id', 'customer_id', 'package_id']);

# Check foreign keys
DB::select("SELECT * FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = 'darkandbright' AND COLUMN_NAME LIKE '%_id'");

exit();
```

### Method 2: Using MySQL CLI

```bash
mysql -u root -p darkandbright

# Check tables
SHOW TABLES;

# Check specific table structure
DESCRIBE order;
DESCRIBE designpackage;

# Check foreign keys
SELECT CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'darkandbright' AND COLUMN_NAME LIKE '%_id';

EXIT;
```

### Method 3: Using Database GUI Tools

- **PhpMyAdmin**: http://localhost/phpmyadmin
- **HeidiSQL**: Download dari heidisql.com
- **MySQL Workbench**: Download dari mysql.com

---

## 📚 Migration Files Reference

Located in `/database/migrations/`:

```
2026_01_24_000001_create_designpackage_table.php
2026_01_24_000002_create_users_table.php
2026_01_24_000003_create_order_table.php
2026_01_24_000004_create_payment_table.php
2026_01_24_000005_create_chatlog_table.php
2026_01_24_000006_create_revision_table.php
2026_01_24_000007_create_finalfile_table.php
2026_01_24_000008_create_guaranteeclaim_table.php
2026_01_24_000009_create_adminreport_table.php
```

---

## 🤖 Model Classes Reference

Located in `/app/Models/`:

```
DesignPackage.php    - Package model dengan relationship ke Order
User.php             - User model (customer & admin)
Order.php            - Order model dengan relasi lengkap
Payment.php          - Payment model
ChatLog.php          - Chat model untuk komunikasi
Revision.php         - Revision model untuk tracking changes
FinalFile.php        - File storage model
GuaranteeClaim.php   - Warranty/claim model
AdminReport.php      - Report aggregation model
```

---

## 💾 Database Backup

### Backup Database

```bash
mysqldump -u root -p darkandbright > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore Database

```bash
mysql -u root -p darkandbright < backup_20260124_120000.sql
```

---

## 🔄 Migration Management Commands

```bash
# Show migration status
php artisan migrate:status

# Rollback last batch
php artisan migrate:rollback

# Rollback all migrations
php artisan migrate:reset

# Refresh (reset + migrate)
php artisan migrate:refresh

# Refresh and seed
php artisan migrate:refresh --seed

# Migrate specific file
php artisan migrate --path=database/migrations/2026_01_24_000001_create_designpackage_table.php

# Rollback specific migration
php artisan migrate:rollback --step=1
```

---

## ✅ Post-Setup Checklist

- [ ] Database created
- [ ] .env configured correctly
- [ ] Migrations run successfully
- [ ] All 9 tables created
- [ ] Foreign keys established
- [ ] Models loaded in app
- [ ] Tinker verification passed
- [ ] Design packages seeded (optional)
- [ ] Ready for development

---

## 📞 Need Help?

Jika mengalami error:

1. **Check Laravel logs**: `storage/logs/laravel.log`
2. **Check MySQL error logs**
3. **Run `php artisan migrate:status`** untuk lihat status migrations
4. **Verify database connection** di .env

---

**Setup Complete! Your Dark and Bright database is ready! 🎉**

Last Updated: 24 January 2026
