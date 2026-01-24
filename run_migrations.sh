#!/bin/bash
# Script untuk menjalankan database migrations sesuai ERD

echo "================================"
echo "Dark and Bright - Database Setup"
echo "================================"
echo ""

# Check if php exists
if ! command -v php &> /dev/null; then
    echo "❌ PHP tidak ditemukan. Pastikan PHP sudah terinstall."
    exit 1
fi

# Navigate to project directory
cd "$(dirname "$0")" || exit

echo "📝 Starting Database Migration..."
echo ""

# Step 1: Check if .env exists
if [ ! -f .env ]; then
    echo "⚠️  File .env tidak ditemukan."
    echo "📋 Silakan copy .env.example ke .env dan konfigurasi database"
    exit 1
fi

# Step 2: Run migrations
echo "🔄 Running migrations..."
php artisan migrate

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Migrations berhasil dijalankan!"
    echo ""
    echo "📊 Tabel-tabel yang dibuat:"
    echo "   ✓ designpackage"
    echo "   ✓ users"
    echo "   ✓ order"
    echo "   ✓ payment"
    echo "   ✓ chatlog"
    echo "   ✓ revision"
    echo "   ✓ finalfile"
    echo "   ✓ guaranteeclaim"
    echo "   ✓ adminreport"
    echo ""
    echo "🚀 Database siap digunakan!"
else
    echo ""
    echo "❌ Error saat menjalankan migrations"
    echo "💡 Cek konfigurasi database di .env"
    echo ""
    echo "Jika ingin reset database, jalankan:"
    echo "   php artisan migrate:reset"
    echo "   php artisan migrate"
    exit 1
fi

echo ""
echo "✨ Selesai!"
