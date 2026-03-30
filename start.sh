#!/bin/bash

# ============================================
#  🚀 POS TOYS - Quick Start Script
#  Jalankan: ./start.sh
# ============================================

set -e

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color
BOLD='\033[1m'

echo ""
echo -e "${BLUE}${BOLD}╔══════════════════════════════════════╗${NC}"
echo -e "${BLUE}${BOLD}║     🚀 POS TOYS - Quick Start       ║${NC}"
echo -e "${BLUE}${BOLD}╚══════════════════════════════════════╝${NC}"
echo ""

# Navigate to project directory
cd "$(dirname "$0")"

# ---- Step 1: Start MySQL via XAMPP ----
echo -e "${YELLOW}[1/4]${NC} Starting MySQL..."

# Check if MySQL is already running
if pgrep -x "mysqld" > /dev/null 2>&1; then
    echo -e "  ${GREEN}✓${NC} MySQL is already running"
else
    # Try XAMPP first, then Homebrew MySQL
    if [ -f "/Applications/XAMPP/xamppfiles/bin/mysql.server" ]; then
        sudo /Applications/XAMPP/xamppfiles/bin/mysql.server start > /dev/null 2>&1
        echo -e "  ${GREEN}✓${NC} MySQL started via XAMPP"
    elif [ -f "/Applications/XAMPP/bin/mysql.server" ]; then
        sudo /Applications/XAMPP/bin/mysql.server start > /dev/null 2>&1
        echo -e "  ${GREEN}✓${NC} MySQL started via XAMPP"
    elif command -v mysql.server &> /dev/null; then
        mysql.server start > /dev/null 2>&1
        echo -e "  ${GREEN}✓${NC} MySQL started via Homebrew"
    elif command -v brew &> /dev/null && brew services list 2>/dev/null | grep -q mysql; then
        brew services start mysql > /dev/null 2>&1
        echo -e "  ${GREEN}✓${NC} MySQL started via Homebrew Services"
    else
        echo -e "  ${RED}✗${NC} Could not auto-start MySQL."
        echo -e "    ${YELLOW}→${NC} Please start XAMPP/MySQL manually, then re-run this script."
        exit 1
    fi
    # Wait for MySQL to be ready
    sleep 2
fi

# ---- Step 2: Install dependencies if needed ----
echo -e "${YELLOW}[2/4]${NC} Checking dependencies..."

if [ ! -d "vendor" ]; then
    echo -e "  ${YELLOW}→${NC} Installing Composer dependencies..."
    composer install --quiet
    echo -e "  ${GREEN}✓${NC} Composer dependencies installed"
else
    echo -e "  ${GREEN}✓${NC} Composer dependencies OK"
fi

if [ ! -d "node_modules" ]; then
    echo -e "  ${YELLOW}→${NC} Installing NPM dependencies..."
    npm install --silent
    echo -e "  ${GREEN}✓${NC} NPM dependencies installed"
else
    echo -e "  ${GREEN}✓${NC} NPM dependencies OK"
fi

# ---- Step 3: Run migrations (if needed) ----
echo -e "${YELLOW}[3/4]${NC} Running migrations..."
php artisan migrate --force --quiet 2>/dev/null && echo -e "  ${GREEN}✓${NC} Database migrated" || echo -e "  ${GREEN}✓${NC} Database up to date"

# ---- Step 4: Start servers ----
echo -e "${YELLOW}[4/4]${NC} Starting development servers..."
echo ""
echo -e "${GREEN}${BOLD}╔══════════════════════════════════════╗${NC}"
echo -e "${GREEN}${BOLD}║  ✅ App ready! Open in browser:      ║${NC}"
echo -e "${GREEN}${BOLD}║  👉 http://localhost:8000            ║${NC}"
echo -e "${GREEN}${BOLD}║                                      ║${NC}"
echo -e "${GREEN}${BOLD}║  Press Ctrl+C to stop all servers    ║${NC}"
echo -e "${GREEN}${BOLD}╚══════════════════════════════════════╝${NC}"
echo ""

# Run Laravel + Vite concurrently
npx concurrently \
    --names "LARAVEL,VITE" \
    --prefix-colors "blue,magenta" \
    --kill-others \
    "php artisan serve" \
    "npm run dev"
