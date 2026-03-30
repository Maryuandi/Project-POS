@echo off
chcp 65001 >nul 2>&1
title POS TOYS - Quick Start

:: ============================================
::  POS TOYS - Quick Start Script (Windows)
::  Jalankan: double-click start.bat
:: ============================================

echo.
echo ╔══════════════════════════════════════╗
echo ║     🚀 POS TOYS - Quick Start       ║
echo ╚══════════════════════════════════════╝
echo.

:: Navigate to script directory
cd /d "%~dp0"

:: ---- Step 1: Start MySQL via XAMPP ----
echo [1/4] Starting MySQL...

:: Check if MySQL is already running
tasklist /FI "IMAGENAME eq mysqld.exe" 2>nul | find /I "mysqld.exe" >nul
if %ERRORLEVEL%==0 (
    echo   ✓ MySQL is already running
) else (
    :: Try common XAMPP paths
    if exist "C:\xampp\mysql\bin\mysqld.exe" (
        echo   → Starting MySQL via XAMPP...
        start "" /B "C:\xampp\mysql\bin\mysqld.exe" --defaults-file="C:\xampp\mysql\bin\my.ini"
        echo   ✓ MySQL started via XAMPP
        timeout /t 3 /nobreak >nul
    ) else if exist "D:\xampp\mysql\bin\mysqld.exe" (
        echo   → Starting MySQL via XAMPP (D:)...
        start "" /B "D:\xampp\mysql\bin\mysqld.exe" --defaults-file="D:\xampp\mysql\bin\my.ini"
        echo   ✓ MySQL started via XAMPP
        timeout /t 3 /nobreak >nul
    ) else if exist "C:\xampp\xampp_start.exe" (
        echo   → Starting XAMPP...
        start "" "C:\xampp\xampp_start.exe"
        echo   ✓ XAMPP started
        timeout /t 5 /nobreak >nul
    ) else (
        echo   ✗ XAMPP not found at default location.
        echo     → Please start XAMPP/MySQL manually, then re-run this script.
        echo     → Or edit this script with your XAMPP path.
        pause
        exit /b 1
    )
)

:: ---- Step 2: Check dependencies ----
echo [2/4] Checking dependencies...

if not exist "vendor" (
    echo   → Installing Composer dependencies...
    call composer install --quiet
    echo   ✓ Composer dependencies installed
) else (
    echo   ✓ Composer dependencies OK
)

if not exist "node_modules" (
    echo   → Installing NPM dependencies...
    call npm install --silent
    echo   ✓ NPM dependencies installed
) else (
    echo   ✓ NPM dependencies OK
)

:: ---- Step 3: Run migrations ----
echo [3/4] Running migrations...
call php artisan migrate --force --quiet 2>nul
echo   ✓ Database up to date

:: ---- Step 4: Start servers ----
echo [4/4] Starting development servers...
echo.
echo ╔══════════════════════════════════════╗
echo ║  ✅ App ready! Open in browser:      ║
echo ║  👉 http://localhost:8000            ║
echo ║                                      ║
echo ║  Close this window to stop servers   ║
echo ╚══════════════════════════════════════╝
echo.

:: Run Laravel + Vite concurrently
call npx concurrently --names "LARAVEL,VITE" --prefix-colors "blue,magenta" --kill-others "php artisan serve" "npm run dev"

pause
