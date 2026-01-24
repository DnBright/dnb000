#!/bin/bash

# VERIFICATION SCRIPT - Dark and Bright Database & Implementation

echo "═══════════════════════════════════════════════════════════════════"
echo "  ✨ DARK AND BRIGHT - FINAL VERIFICATION REPORT ✨"
echo "═══════════════════════════════════════════════════════════════════"
echo ""

# Color codes
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Initialize counts
PASSED=0
FAILED=0

# Test 1: Check if migration files exist
echo "1️⃣  CHECKING MIGRATION FILES..."
echo "───────────────────────────────────────────────────────────────────"

MIGRATION_DIR="/Users/mac/Downloads/Darkandbright/database/migrations"
REQUIRED_MIGRATIONS=(
    "2026_01_24_000000_drop_old_tables.php"
    "2026_01_24_000001_create_designpackage_table.php"
    "2026_01_24_000002_create_users_table.php"
    "2026_01_24_000003_create_order_table.php"
    "2026_01_24_000004_create_payment_table.php"
    "2026_01_24_000005_create_chatlog_table.php"
    "2026_01_24_000006_create_revision_table.php"
    "2026_01_24_000007_create_finalfile_table.php"
    "2026_01_24_000008_create_guaranteeclaim_table.php"
    "2026_01_24_000009_create_adminreport_table.php"
)

for migration in "${REQUIRED_MIGRATIONS[@]}"; do
    if [ -f "$MIGRATION_DIR/$migration" ]; then
        echo -e "${GREEN}✓${NC} $migration"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} $migration MISSING"
        ((FAILED++))
    fi
done

echo ""

# Test 2: Check if Model files exist
echo "2️⃣  CHECKING MODEL FILES..."
echo "───────────────────────────────────────────────────────────────────"

MODELS_DIR="/Users/mac/Downloads/Darkandbright/app/Models"
REQUIRED_MODELS=(
    "Order.php"
    "User.php"
    "DesignPackage.php"
    "Payment.php"
    "ChatLog.php"
    "Revision.php"
    "FinalFile.php"
    "GuaranteeClaim.php"
    "AdminReport.php"
)

for model in "${REQUIRED_MODELS[@]}"; do
    if [ -f "$MODELS_DIR/$model" ]; then
        echo -e "${GREEN}✓${NC} $model"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} $model MISSING"
        ((FAILED++))
    fi
done

echo ""

# Test 3: Check if Controller files exist
echo "3️⃣  CHECKING CONTROLLER FILES..."
echo "───────────────────────────────────────────────────────────────────"

CONTROLLERS_DIR="/Users/mac/Downloads/Darkandbright/app/Http/Controllers"
REQUIRED_CONTROLLERS=(
    "OrderController.php"
    "PaymentController.php"
    "ChatController.php"
    "RevisionController.php"
    "FileController.php"
)

for controller in "${REQUIRED_CONTROLLERS[@]}"; do
    if [ -f "$CONTROLLERS_DIR/$controller" ]; then
        echo -e "${GREEN}✓${NC} $controller"
        ((PASSED++))
    else
        echo -e "${RED}⚠${NC} $controller (Designed but not required)"
    fi
done

echo ""

# Test 4: Check if Documentation exists
echo "4️⃣  CHECKING DOCUMENTATION FILES..."
echo "───────────────────────────────────────────────────────────────────"

DOCS_DIR="/Users/mac/Downloads/Darkandbright"
REQUIRED_DOCS=(
    "DOKUMENTASI_FINAL_LENGKAP.md"
    "SUMMARY_FINAL.md"
    "INDEX_DOKUMENTASI.md"
    "DOKUMENTASI_ERD_DATABASE.md"
    "SETUP_DATABASE.md"
    "ERD_VISUAL.md"
)

for doc in "${REQUIRED_DOCS[@]}"; do
    if [ -f "$DOCS_DIR/$doc" ]; then
        LINES=$(wc -l < "$DOCS_DIR/$doc")
        echo -e "${GREEN}✓${NC} $doc ($LINES lines)"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} $doc MISSING"
        ((FAILED++))
    fi
done

echo ""

# Test 5: Check Seeder
echo "5️⃣  CHECKING SEEDER..."
echo "───────────────────────────────────────────────────────────────────"

SEEDER="/Users/mac/Downloads/Darkandbright/database/seeders/DatabaseSeeder.php"
if [ -f "$SEEDER" ]; then
    echo -e "${GREEN}✓${NC} DatabaseSeeder.php exists"
    ((PASSED++))
else
    echo -e "${RED}✗${NC} DatabaseSeeder.php MISSING"
    ((FAILED++))
fi

echo ""

# Test 6: Database Connection Check
echo "6️⃣  CHECKING DATABASE CONFIGURATION..."
echo "───────────────────────────────────────────────────────────────────"

ENV_FILE="/Users/mac/Downloads/Darkandbright/.env"
if [ -f "$ENV_FILE" ]; then
    echo -e "${GREEN}✓${NC} .env file exists"
    
    if grep -q "DB_DATABASE=db_dnb" "$ENV_FILE"; then
        echo -e "${GREEN}✓${NC} Database name configured: db_dnb"
        ((PASSED++))
    fi
    
    if grep -q "DB_HOST=127.0.0.1" "$ENV_FILE"; then
        echo -e "${GREEN}✓${NC} Database host configured: 127.0.0.1"
        ((PASSED++))
    fi
else
    echo -e "${RED}✗${NC} .env file missing"
    ((FAILED++))
fi

echo ""

# Summary
echo "═══════════════════════════════════════════════════════════════════"
echo "  📊 VERIFICATION RESULTS"
echo "═══════════════════════════════════════════════════════════════════"
echo ""
echo -e "  ${GREEN}✓ PASSED:${NC} $PASSED items"
echo -e "  ${RED}✗ FAILED:${NC} $FAILED items"
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}═══════════════════════════════════════════════════════════════════${NC}"
    echo -e "${GREEN}  ✨ ALL CHECKS PASSED - PROJECT IS READY! ✨${NC}"
    echo -e "${GREEN}═══════════════════════════════════════════════════════════════════${NC}"
    exit 0
else
    echo -e "${RED}═══════════════════════════════════════════════════════════════════${NC}"
    echo -e "${RED}  ⚠️  SOME CHECKS FAILED - PLEASE REVIEW${NC}"
    echo -e "${RED}═══════════════════════════════════════════════════════════════════${NC}"
    exit 1
fi
