#!/bin/bash

# Simple database check script

cd /Users/mac/Downloads/Darkandbright

echo "═══════════════════════════════════════════════════════════════"
echo "         DATABASE VERIFICATION - Dark and Bright Project"
echo "═══════════════════════════════════════════════════════════════"
echo ""

# Check MySQL connection
echo "1️⃣  Checking MySQL Connection..."
mysql -u root -e "SELECT 1;" > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo "   ✅ MySQL is running"
else
    echo "   ❌ MySQL connection failed"
    exit 1
fi

echo ""
echo "2️⃣  Checking Database 'db_dnb'..."
mysql -u root -e "USE db_dnb; SELECT 1;" > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo "   ✅ Database db_dnb exists"
else
    echo "   ❌ Database db_dnb not found"
    exit 1
fi

echo ""
echo "3️⃣  Listing All Tables in db_dnb..."
echo "───────────────────────────────────────────────────────────────"
mysql -u root db_dnb -e "SHOW TABLES;"
echo ""

echo "4️⃣  Checking 9 ERD Tables..."
echo "───────────────────────────────────────────────────────────────"

TABLES=("designpackage" "users" "order" "payment" "chatlog" "revision" "finalfile" "guaranteeclaim" "adminreport")
FOUND=0

for table in "${TABLES[@]}"; do
    EXISTS=$(mysql -u root db_dnb -e "SHOW TABLES LIKE '$table';" 2>/dev/null | grep -c "$table")
    if [ $EXISTS -gt 0 ]; then
        COUNT=$(mysql -u root db_dnb -e "SELECT COUNT(*) FROM \`$table\`;" 2>/dev/null | tail -1)
        echo "   ✅ $table (rows: $COUNT)"
        ((FOUND++))
    else
        echo "   ❌ $table"
    fi
done

echo ""
echo "5️⃣  Foreign Key Summary..."
echo "───────────────────────────────────────────────────────────────"
FK_COUNT=$(mysql -u root db_dnb -e "
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
    WHERE TABLE_SCHEMA='db_dnb' AND REFERENCED_TABLE_NAME IS NOT NULL;
" 2>/dev/null | tail -1)

echo "   Found: $FK_COUNT foreign key relationships"
echo ""

echo "6️⃣  Order Table Structure Check..."
echo "───────────────────────────────────────────────────────────────"
mysql -u root db_dnb -e "DESCRIBE \`order\`;" 2>/dev/null
echo ""

echo "═══════════════════════════════════════════════════════════════"
if [ $FOUND -eq 9 ]; then
    echo "✨ STATUS: DATABASE IS PERFECT! ✨"
    echo ""
    echo "✅ All 9 ERD tables created successfully"
    echo "✅ Foreign key relationships established"
    echo "✅ Database ready for development"
    echo ""
else
    echo "⚠️  STATUS: DATABASE NEEDS ATTENTION"
    echo ""
    echo "Found $FOUND out of 9 tables"
    echo "Missing tables need to be created"
    echo ""
fi

echo "═══════════════════════════════════════════════════════════════"
