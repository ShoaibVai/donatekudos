@echo off
SETLOCAL EnableDelayedExpansion

echo ========================================
echo   DonateKudos Project Setup Script
echo ========================================
echo.

REM Change to script directory
cd /d "%~dp0"

REM Color codes (optional - for better visibility)
REM Check if running with admin privileges
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo [WARNING] Not running as administrator. Some operations may fail.
    echo.
)

REM ========================================
REM Step 1: Check Prerequisites
REM ========================================
echo [STEP 1/10] Checking prerequisites...
echo.

REM Check PHP
php --version >nul 2>&1
if %errorLevel% neq 0 (
    echo [ERROR] PHP is not installed or not in PATH
    echo Please install PHP 8.1 or higher from: https://windows.php.net/download/
    echo After installation, add PHP to your system PATH
    pause
    exit /b 1
) else (
    echo [OK] PHP found:
    php --version | findstr /C:"PHP"
)

REM Check Composer
composer --version >nul 2>&1
if %errorLevel% neq 0 (
    echo [ERROR] Composer is not installed or not in PATH
    echo Please install Composer from: https://getcomposer.org/download/
    pause
    exit /b 1
) else (
    echo [OK] Composer found:
    composer --version | findstr /C:"Composer"
)

REM Check Node.js
node --version >nul 2>&1
if %errorLevel% neq 0 (
    echo [ERROR] Node.js is not installed or not in PATH
    echo Please install Node.js from: https://nodejs.org/
    pause
    exit /b 1
) else (
    echo [OK] Node.js found:
    node --version
)

REM Check NPM
npm --version >nul 2>&1
if %errorLevel% neq 0 (
    echo [ERROR] NPM is not installed or not in PATH
    echo NPM should come with Node.js installation
    pause
    exit /b 1
) else (
    echo [OK] NPM found:
    npm --version
)

echo.
echo All prerequisites are satisfied!
echo.
pause

REM ========================================
REM Step 2: Install Composer Dependencies
REM ========================================
echo [STEP 2/10] Installing Composer dependencies...
echo.

if not exist "composer.json" (
    echo [ERROR] composer.json not found in current directory
    pause
    exit /b 1
)

composer install --no-interaction --prefer-dist --optimize-autoloader
if %errorLevel% neq 0 (
    echo [ERROR] Composer install failed
    pause
    exit /b 1
)

echo.
echo [OK] Composer dependencies installed successfully!
echo.

REM ========================================
REM Step 3: Install NPM Dependencies
REM ========================================
echo [STEP 3/10] Installing NPM dependencies...
echo.

if not exist "package.json" (
    echo [ERROR] package.json not found in current directory
    pause
    exit /b 1
)

npm install
if %errorLevel% neq 0 (
    echo [ERROR] NPM install failed
    pause
    exit /b 1
)

echo.
echo [OK] NPM dependencies installed successfully!
echo.

REM ========================================
REM Step 4: Setup Environment File
REM ========================================
echo [STEP 4/10] Setting up environment file...
echo.

if not exist ".env" (
    if exist ".env.example" (
        copy ".env.example" ".env"
        echo [OK] .env file created from .env.example
    ) else (
        echo [WARNING] .env.example not found. Please create .env manually
    )
) else (
    echo [INFO] .env file already exists, skipping...
)

echo.

REM ========================================
REM Step 5: Generate Application Key
REM ========================================
echo [STEP 5/10] Generating application key...
echo.

php artisan key:generate --ansi
if %errorLevel% neq 0 (
    echo [ERROR] Failed to generate application key
    pause
    exit /b 1
)

echo.
echo [OK] Application key generated successfully!
echo.

REM ========================================
REM Step 6: Create Storage Directories
REM ========================================
echo [STEP 6/10] Setting up storage directories...
echo.

REM Create necessary directories if they don't exist
if not exist "storage\app\public" mkdir "storage\app\public"
if not exist "storage\framework\cache" mkdir "storage\framework\cache"
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\testing" mkdir "storage\framework\testing"
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "storage\logs" mkdir "storage\logs"
if not exist "bootstrap\cache" mkdir "bootstrap\cache"

echo [OK] Storage directories created/verified!
echo.

REM ========================================
REM Step 7: Set Directory Permissions
REM ========================================
echo [STEP 7/10] Setting directory permissions...
echo.

REM On Windows, we'll just ensure the directories exist and are writable
REM Laravel should be able to write to these directories by default on Windows

icacls "storage" /grant:r "%USERNAME%:(OI)(CI)F" /T >nul 2>&1
icacls "bootstrap\cache" /grant:r "%USERNAME%:(OI)(CI)F" /T >nul 2>&1

echo [OK] Directory permissions set!
echo.

REM ========================================
REM Step 8: Create Storage Link
REM ========================================
echo [STEP 8/10] Creating storage symbolic link...
echo.

REM Remove existing link if it exists
if exist "public\storage" (
    rmdir "public\storage" >nul 2>&1
)

php artisan storage:link
if %errorLevel% neq 0 (
    echo [WARNING] Failed to create storage link. You may need to run this as administrator
    echo You can manually create the link later by running: php artisan storage:link
) else (
    echo [OK] Storage link created successfully!
)

echo.

REM ========================================
REM Step 9: Database Setup
REM ========================================
echo [STEP 9/10] Database setup...
echo.

echo Please ensure your database is configured in the .env file
echo Default Laravel uses SQLite, but you may configure MySQL/PostgreSQL
echo.

set /p RUN_MIGRATIONS="Do you want to run database migrations now? (y/n): "
if /i "%RUN_MIGRATIONS%"=="y" (
    echo.
    echo Running migrations...
    php artisan migrate --force
    if %errorLevel% neq 0 (
        echo [WARNING] Migrations failed. Please check your database configuration in .env
        echo You can run migrations later with: php artisan migrate
    ) else (
        echo [OK] Migrations completed successfully!
        
        echo.
        set /p RUN_SEEDERS="Do you want to run database seeders? (y/n): "
        if /i "!RUN_SEEDERS!"=="y" (
            php artisan db:seed --force
            if %errorLevel% neq 0 (
                echo [WARNING] Seeding failed
            ) else (
                echo [OK] Database seeded successfully!
            )
        )
    )
) else (
    echo [INFO] Skipping migrations. Run manually with: php artisan migrate
)

echo.

REM ========================================
REM Step 10: Build Frontend Assets
REM ========================================
echo [STEP 10/10] Building frontend assets...
echo.

set /p BUILD_ASSETS="Do you want to build frontend assets now? (y/n): "
if /i "%BUILD_ASSETS%"=="y" (
    echo.
    echo Building assets (this may take a moment)...
    npm run build
    if %errorLevel% neq 0 (
        echo [WARNING] Asset build failed
        echo You can build assets later with: npm run build
    ) else (
        echo [OK] Assets built successfully!
    )
) else (
    echo [INFO] Skipping asset build. Run manually with: npm run build
)

echo.

REM ========================================
REM Setup Complete
REM ========================================
echo.
echo ========================================
echo   Setup Complete!
echo ========================================
echo.
echo Your Laravel application is now set up!
echo.
echo Next steps:
echo   1. Configure your .env file with database credentials
echo   2. Run migrations if you haven't: php artisan migrate
echo   3. Start development server: php artisan serve
echo   4. In another terminal, run: npm run dev (for asset compilation)
echo.
echo Access your application at: http://localhost:8000
echo.
echo For admin features, you may need to create an admin user manually
echo or run any seeders you have configured.
echo.
echo ========================================

pause
ENDLOCAL
