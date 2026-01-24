# 🔧 DATABASE MIGRATION TROUBLESHOOTING GUIDE

## Problem
The migration failed because:
```
SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'users' already exists
```

This happens because there are **old migrations** from December 2025 that create the same tables:
- `2025_12_14_075342_create_users_table.php` ← **CONFLICT**
- `2025_12_14_075756_create_admins_table.php` ← **CONFLICT**
- `2025_12_12_050955_create_orders_table.php` ← **CONFLICT**

These run BEFORE our new 2026 migrations because of alphabetical timestamp ordering.

---

## Solution

### Method 1: Manual Steps (Recommended)

#### Step 1: Delete Old Conflicting Migration Files
```bash
cd /Users/mac/Downloads/Darkandbright/database/migrations

# Delete old migrations that conflict
rm 2025_12_14_075342_create_users_table.php
rm 2025_12_14_075756_create_admins_table.php
rm 2025_12_12_050955_create_orders_table.php
```

#### Step 2: Drop and Recreate Database
```bash
# Drop database
mysql -u root -e "DROP DATABASE IF EXISTS db_dnb;"

# Create fresh database
mysql -u root -e "CREATE DATABASE db_dnb;"
```

#### Step 3: Run New Migrations
```bash
cd /Users/mac/Downloads/Darkandbright
php artisan migrate --fresh
```

#### Step 4: Verify
```bash
php artisan tinker

# In tinker, run:
DB::table('designpackage')->count()
DB::table('users')->count()
DB::table('order')->count()
DB::table('payment')->count()
DB::table('chatlog')->count()
DB::table('revision')->count()
DB::table('finalfile')->count()
DB::table('guaranteeclaim')->count()
DB::table('adminreport')->count()

# Should show all 9 tables exist
exit()
```

---

### Method 2: Using Drop Migration (Already Created)

We've created `2026_01_24_000000_drop_old_tables.php` which will:
1. Drop old tables BEFORE our new ones are created
2. This migration runs first (earliest timestamp: 000000)
3. Prevents table conflicts

**Simply run:**
```bash
cd /Users/mac/Downloads/Darkandbright
php artisan migrate:refresh
```

---

### Method 3: Complete Reset
```bash
# From project root
cd /Users/mac/Downloads/Darkandbright

# Option A: Fresh migration (cleanest)
php artisan migrate:fresh

# Option B: Reset old data (keeps framework tables)
php artisan migrate:reset
php artisan migrate

# Option C: Seed after migration
php artisan migrate:fresh --seed
```

---

## After Migration: Verification Checklist

Run these commands to verify all 9 tables were created:

```bash
# Connect to database
mysql -u root db_dnb

# Run these SQL commands:

-- Count total tables
SELECT COUNT(*) as total_tables FROM information_schema.TABLES WHERE TABLE_SCHEMA='db_dnb';

-- List all tables
SHOW TABLES;

-- Verify specific tables exist
DESCRIBE designpackage;
DESCRIBE users;
DESCRIBE order;
DESCRIBE payment;
DESCRIBE chatlog;
DESCRIBE revision;
DESCRIBE finalfile;
DESCRIBE guaranteeclaim;
DESCRIBE adminreport;

-- Check for foreign keys
SELECT CONSTRAINT_NAME, TABLE_NAME, REFERENCED_TABLE_NAME 
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA='db_dnb' AND REFERENCED_TABLE_NAME IS NOT NULL;
```

---

## What Each Migration Does

| Order | File | Action | Table |
|-------|------|--------|-------|
| 1 | `2026_01_24_000000_drop_old_tables.php` | DROP old tables | users, admins, orders, posts, sessions |
| 2 | `2026_01_24_000001_create_designpackage_table.php` | CREATE new | designpackage |
| 3 | `2026_01_24_000002_create_users_table.php` | CREATE new | users (with user_id PK) |
| 4 | `2026_01_24_000003_create_order_table.php` | CREATE new | order (with order_id PK) |
| 5 | `2026_01_24_000004_create_payment_table.php` | CREATE new | payment |
| 6 | `2026_01_24_000005_create_chatlog_table.php` | CREATE new | chatlog |
| 7 | `2026_01_24_000006_create_revision_table.php` | CREATE new | revision |
| 8 | `2026_01_24_000007_create_finalfile_table.php` | CREATE new | finalfile |
| 9 | `2026_01_24_000008_create_guaranteeclaim_table.php` | CREATE new | guaranteeclaim |
| 10 | `2026_01_24_000009_create_adminreport_table.php` | CREATE new | adminreport |

---

## Expected Output After Success

```
   INFO  Running migrations.

  2026_01_24_000000_drop_old_tables ............................................. 25.15ms DONE
  2026_01_24_000001_create_designpackage_table .................................. 42.05ms DONE
  2026_01_24_000002_create_users_table ........................................... 15.30ms DONE
  2026_01_24_000003_create_order_table ........................................... 18.75ms DONE
  2026_01_24_000004_create_payment_table ......................................... 12.40ms DONE
  2026_01_24_000005_create_chatlog_table ......................................... 14.20ms DONE
  2026_01_24_000006_create_revision_table ........................................ 11.80ms DONE
  2026_01_24_000007_create_finalfile_table ....................................... 10.50ms DONE
  2026_01_24_000008_create_guaranteeclaim_table .................................. 11.20ms DONE
  2026_01_24_000009_create_adminreport_table ..................................... 9.90ms DONE

   INFO  Database seeding completed successfully.
```

---

## Common Issues & Solutions

### Issue: "Table already exists"
**Solution:** Delete old migration files (Method 1, Step 1)

### Issue: "Foreign key constraint fails"
**Solution:** Ensure migrations run in correct order (they should by timestamp)

### Issue: "Unkn table or alias"
**Solution:** Verify table name is correct (uses lowercase, no spaces)

### Issue: "Lost connection to MySQL"
**Solution:** Check MySQL is running
```bash
# Check MySQL status
mysql -u root -e "SELECT 1;"

# Start MySQL (if using XAMPP/Laragon/MAMP)
# On Mac with Homebrew: brew services start mysql
```

---

## 🎯 Quick Command Summary

```bash
# One-liner to reset everything
cd /Users/mac/Downloads/Darkandbright && \
mysql -u root -e "DROP DATABASE IF EXISTS db_dnb; CREATE DATABASE db_dnb;" && \
php artisan migrate

# Or with seeding
php artisan migrate:fresh --seed

# Verify
php artisan tinker
>>> DB::table('designpackage')->count()
=> 0
>>> exit()
```

---

## Support Files

- [DOKUMENTASI_ERD_DATABASE.md](DOKUMENTASI_ERD_DATABASE.md) - Full ERD documentation
- [SETUP_DATABASE.md](SETUP_DATABASE.md) - Detailed setup guide
- [ERD_VISUAL.md](ERD_VISUAL.md) - Visual diagrams
- [IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md) - Quick reference

---

**Status:** Waiting for migration execution  
**Next Step:** Run the migration command above  
**Expected Result:** 10 migrations completed, 9 new tables created ✅
