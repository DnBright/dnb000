#!/bin/bash

# Dark and Bright Database Migration Script
# This script will set up the new 9-table ERD structure

cd /Users/mac/Downloads/Darkandbright

echo "================================"
echo "Dark and Bright Database Setup"
echo "================================"
echo ""

# Check if database exists
echo "Checking database connection..."
mysql -u root db_dnb -e "SELECT 1" 2>/dev/null
if [ $? -eq 0 ]; then
    echo "✓ Database connection successful"
else
    echo "✗ Cannot connect to database"
    echo "Please create database first: mysql -u root -e 'CREATE DATABASE db_dnb;'"
    exit 1
fi

echo ""
echo "Running migrations..."
php artisan migrate:fresh

echo ""
echo "Verifying tables..."
mysql -u root db_dnb -e "SHOW TABLES;" 

echo ""
echo "================================"
echo "Migration complete!"
echo "================================"
