@echo off
REM ============================================================================
REM DonateKudos Platform - Complete Project Setup Script
REM ============================================================================
REM This script sets up the entire DonateKudos project on a new device
REM Compatible with Windows 10/11
REM Prerequisites: Git, PHP, Composer installed
REM ============================================================================

setlocal enabledelayedexpansion
cd /d "%~dp0"

REM Colors for console output
set "INFO=[INFO]"
set "SUCCESS=[SUCCESS]"
set "ERROR=[ERROR]"
set "WARNING=[WARNING]"

cls
echo.
echo ============================================================================
echo                    DonateKudos Platform - Setup Wizard
echo ============================================================================
echo.

REM Check if running as Administrator
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo %ERROR% This script requires Administrator privileges!
    echo Please run Command Prompt as Administrator
    pause
    exit /b 1
)

echo %INFO% Starting DonateKudos setup...
echo.

REM ============================================================================
REM STEP 1: Check Prerequisites
REM ============================================================================
echo.
echo ============================================================================
echo STEP 1: Checking Prerequisites
echo ============================================================================
echo.

echo %INFO% Checking for Git...
git --version >nul 2>&1
if %errorLevel% neq 0 (
    echo %ERROR% Git is not installed or not in PATH!
    echo Please install Git from https://git-scm.com/download/win
    pause
    exit /b 1
) else (
    echo %SUCCESS% Git found: %git%
)

echo %INFO% Checking for PHP...
php -v >nul 2>&1
if %errorLevel% neq 0 (
    echo %ERROR% PHP is not installed or not in PATH!
    echo Please install PHP from https://www.php.net/downloads
    pause
    exit /b 1
) else (
    for /f "tokens=2" %%i in ('php -v ^| findstr /i "PHP"') do (
        echo %SUCCESS% PHP found: %%i
        goto :php_found
    )
    :php_found
)

echo %INFO% Checking for Composer...
composer --version >nul 2>&1
if %errorLevel% neq 0 (
    echo %ERROR% Composer is not installed or not in PATH!
    echo Please install Composer from https://getcomposer.org/download/
    pause
    exit /b 1
) else (
    for /f "tokens=3" %%i in ('composer --version') do (
        echo %SUCCESS% Composer found
        goto :composer_found
    )
    :composer_found
)

echo %INFO% All prerequisites are installed!
echo.
pause

REM ============================================================================
REM STEP 2: Clone or Setup Repository
REM ============================================================================
echo.
echo ============================================================================
echo STEP 2: Repository Setup
echo ============================================================================
echo.

set "REPO_DIR=%CD%\donatekudos"

if exist "%REPO_DIR%" (
    echo %INFO% Repository already exists at %REPO_DIR%
    echo %INFO% Pulling latest changes...
    cd /d "%REPO_DIR%"
    git pull origin main
) else (
    echo %INFO% Cloning repository...
    git clone https://github.com/ShoaibVai/donatekudos.git "%REPO_DIR%"
    if %errorLevel% neq 0 (
        echo %ERROR% Failed to clone repository!
        pause
        exit /b 1
    )
    cd /d "%REPO_DIR%"
)

echo %SUCCESS% Repository ready at %REPO_DIR%
cd /d "%REPO_DIR%\laravel"
echo %INFO% Working directory: %CD%
echo.
pause

REM ============================================================================
REM STEP 3: Install PHP Dependencies
REM ============================================================================
echo.
echo ============================================================================
echo STEP 3: Installing PHP Dependencies
echo ============================================================================
echo.

echo %INFO% Installing Composer dependencies...
echo %INFO% This may take several minutes...
echo.

composer install

if %errorLevel% neq 0 (
    echo %ERROR% Composer install failed!
    pause
    exit /b 1
)

echo %SUCCESS% Composer dependencies installed!
echo.
pause

REM ============================================================================
REM STEP 4: Environment Configuration
REM ============================================================================
echo.
echo ============================================================================
echo STEP 4: Environment Configuration
echo ============================================================================
echo.

if exist ".env" (
    echo %WARNING% .env file already exists
    set /p OVERWRITE="Overwrite existing .env? (y/n): "
    if /i "!OVERWRITE!"=="n" (
        echo %INFO% Using existing .env file
        goto :skip_env
    )
)

if not exist ".env.example" (
    echo %ERROR% .env.example file not found!
    pause
    exit /b 1
)

echo %INFO% Creating .env file from .env.example...
copy ".env.example" ".env"

echo %INFO% Configuring .env file...

REM Generate APP_KEY
echo %INFO% Generating application key...
php artisan key:generate

REM Configure database
echo.
echo %INFO% Setting database configuration...
echo Database file will be created at: database/database.sqlite
echo.

REM Update .env for SQLite
(
    for /f "delims=" %%a in (.env) do (
        if "%%a"=="" (
            echo.
        ) else if "%%a:~0,11%"=="DB_DATABASE" (
            echo DB_DATABASE=%CD%\database\database.sqlite
        ) else (
            echo %%a
        )
    )
) > .env.tmp
move /y .env.tmp .env

echo %SUCCESS% .env file configured!
echo.

:skip_env
pause

REM ============================================================================
REM STEP 5: Database Setup
REM ============================================================================
echo.
echo ============================================================================
echo STEP 5: Database Setup
echo ============================================================================
echo.

if exist "database\database.sqlite" (
    echo %WARNING% Database file already exists
    set /p RESET_DB="Reset database? (y/n): "
    if /i "!RESET_DB!"=="y" (
        echo %INFO% Deleting existing database...
        del /f /q database\database.sqlite
    )
)

echo %INFO% Creating SQLite database file...
if not exist "database\database.sqlite" (
    type nul > database\database.sqlite
)

echo %INFO% Running migrations...
php artisan migrate

if %errorLevel% neq 0 (
    echo %ERROR% Migration failed!
    pause
    exit /b 1
)

echo %SUCCESS% Database migrations completed!
echo.
pause

REM ============================================================================
REM STEP 6: Seed Database (Optional)
REM ============================================================================
echo.
echo ============================================================================
echo STEP 6: Seed Database (Optional)
echo ============================================================================
echo.

set /p SEED_DB="Do you want to seed test data? (y/n): "
if /i "!SEED_DB!"=="y" (
    echo %INFO% Seeding database with test data...
    php artisan db:seed
    if %errorLevel% neq 0 (
        echo %WARNING% Database seeding had issues
    ) else (
        echo %SUCCESS% Test data seeded!
    )
) else (
    echo %INFO% Skipping database seeding
)
echo.
pause

REM ============================================================================
REM STEP 7: Storage Setup
REM ============================================================================
echo.
echo ============================================================================
echo STEP 7: Storage Setup
echo ============================================================================
echo.

echo %INFO% Creating storage symlink...
php artisan storage:link

if %errorLevel% neq 0 (
    echo %WARNING% Storage symlink creation had issues
    echo %INFO% Try running manually: php artisan storage:link
) else (
    echo %SUCCESS% Storage symlink created!
)
echo.
pause

REM ============================================================================
REM STEP 8: Node Dependencies (if needed for frontend)
REM ============================================================================
echo.
echo ============================================================================
echo STEP 8: Node.js Dependencies (Optional)
echo ============================================================================
echo.

set /p INSTALL_NODE="Install Node.js dependencies? (y/n): "
if /i "!INSTALL_NODE!"=="y" (
    echo %INFO% Checking for Node.js...
    node --version >nul 2>&1
    if %errorLevel% neq 0 (
        echo %WARNING% Node.js not found! Install from https://nodejs.org/
        echo %INFO% Skipping npm install
    ) else (
        echo %INFO% Installing npm dependencies...
        npm install
        if %errorLevel% neq 0 (
            echo %WARNING% npm install had issues
        ) else (
            echo %SUCCESS% npm dependencies installed!
        )
    )
) else (
    echo %INFO% Skipping npm dependencies
)
echo.
pause

REM ============================================================================
REM STEP 9: Cache and View Optimization
REM ============================================================================
echo.
echo ============================================================================
echo STEP 9: Optimizing Application
echo ============================================================================
echo.

echo %INFO% Clearing caches...
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

echo %SUCCESS% Caches cleared!
echo.
pause

REM ============================================================================
REM STEP 10: Final Verification
REM ============================================================================
echo.
echo ============================================================================
echo STEP 10: Verification
echo ============================================================================
echo.

echo %INFO% Verifying setup...
echo.

echo Checking key files...
if exist ".env" (
    echo  ✓ .env file exists
) else (
    echo  ✗ .env file MISSING
)

if exist "database\database.sqlite" (
    echo  ✓ Database file exists
) else (
    echo  ✗ Database file MISSING
)

if exist "storage\logs" (
    echo  ✓ Storage logs directory exists
) else (
    echo  ✗ Storage logs directory MISSING
)

if exist "public\storage" (
    echo  ✓ Storage symlink exists
) else (
    echo  ✗ Storage symlink MISSING
)

echo.
echo %INFO% Verifying routes...
php artisan route:list >nul 2>&1
if %errorLevel% neq 0 (
    echo  ✗ Routes check failed
) else (
    echo  ✓ Routes configured correctly
)

echo.

REM ============================================================================
REM STEP 11: Test Account Information
REM ============================================================================
echo.
echo ============================================================================
echo STEP 11: Test Credentials
echo ============================================================================
echo.

if %errorLevel% equ 0 (
    echo %SUCCESS% Setup Complete!
    echo.
    echo ============================================================================
    echo                         TEST CREDENTIALS
    echo ============================================================================
    echo.
    echo If you seeded test data, use these credentials:
    echo.
    echo Username: John Donate
    echo Email:    john@donate.com
    echo Password: password
    echo.
    echo Or Admin Credentials:
    echo Username: admin
    echo Password: admin
    echo.
    echo ============================================================================
    echo                         NEXT STEPS
    echo ============================================================================
    echo.
    echo 1. Start the development server:
    echo    php artisan serve
    echo.
    echo 2. Open your browser and navigate to:
    echo    http://127.0.0.1:8000
    echo.
    echo 3. Log in with the test credentials above
    echo.
    echo ============================================================================
    echo.
    echo %INFO% Setting up quick start commands...
    echo.
)

pause

REM ============================================================================
REM STEP 12: Create Convenience Scripts
REM ============================================================================
echo.
echo ============================================================================
echo STEP 12: Creating Convenience Scripts
echo ============================================================================
echo.

REM Create start server script
(
    echo @echo off
    echo cd /d "%CD%"
    echo echo Starting DonateKudos Development Server...
    echo echo.
    echo echo Application URL: http://127.0.0.1:8000
    echo echo.
    echo echo Press Ctrl+C to stop the server
    echo echo.
    echo php artisan serve
) > "start-server.bat"

echo %SUCCESS% Created start-server.bat
echo Run it to start development server

REM Create database reset script
(
    echo @echo off
    echo cd /d "%CD%"
    echo echo WARNING: This will delete all data and reset the database!
    echo set /p CONFIRM="Are you sure? (y/n): "
    echo if /i "!CONFIRM!"=="y" (
    echo     del /f /q database\database.sqlite
    echo     type nul ^> database\database.sqlite
    echo     php artisan migrate
    echo     php artisan db:seed
    echo     echo Database reset complete!
    echo ) else (
    echo     echo Cancelled
    echo )
    echo pause
) > "reset-database.bat"

echo %SUCCESS% Created reset-database.bat
echo Run it to reset database

REM Create cache clear script
(
    echo @echo off
    echo cd /d "%CD%"
    echo echo Clearing caches...
    echo php artisan cache:clear
    echo php artisan view:clear
    echo php artisan config:clear
    echo php artisan route:clear
    echo echo Caches cleared!
    echo pause
) > "clear-cache.bat"

echo %SUCCESS% Created clear-cache.bat
echo Run it to clear caches

echo.
pause

REM ============================================================================
REM Final Summary
REM ============================================================================
cls
echo.
echo ============================================================================
echo                    SETUP COMPLETE! 
echo ============================================================================
echo.
echo %SUCCESS% DonateKudos Platform has been successfully set up!
echo.
echo Project Location: %REPO_DIR%
echo Working Directory: %CD%
echo.
echo ============================================================================
echo                    QUICK START GUIDE
echo ============================================================================
echo.
echo 1. Navigate to project directory:
echo    cd "%CD%"
echo.
echo 2. Start the development server:
echo    php artisan serve
echo    (or double-click: start-server.bat)
echo.
echo 3. Open your browser:
echo    http://127.0.0.1:8000
echo.
echo 4. Log in with test credentials:
echo    Email: john@donate.com
echo    Password: password
echo.
echo ============================================================================
echo                    CONVENIENCE SCRIPTS
echo ============================================================================
echo.
echo The following scripts have been created:
echo.
echo  • start-server.bat ............ Start development server
echo  • reset-database.bat .......... Reset database to clean state
echo  • clear-cache.bat ............ Clear application caches
echo.
echo ============================================================================
echo                    IMPORTANT FILES
echo ============================================================================
echo.
echo  • .env ........................ Application configuration
echo  • database.sqlite ............ Application database
echo  • public/storage ............. Uploaded files symlink
echo  • storage/logs ............... Application logs
echo.
echo ============================================================================
echo                    DOCUMENTATION
echo ============================================================================
echo.
echo Check the following files for more information:
echo.
echo  • COMPREHENSIVE_AUDIT_REPORT.md ... Full technical documentation
echo  • FINAL_AUDIT_APPROVAL.md ......... Deployment guide
echo  • README.md ...................... Project readme
echo.
echo ============================================================================
echo                    TROUBLESHOOTING
echo ============================================================================
echo.
echo If you encounter issues:
echo.
echo 1. Clear cache:
    echo    Run: clear-cache.bat
echo.
echo 2. Reset database:
echo    Run: reset-database.bat
echo.
echo 3. Check logs:
echo    View: storage/logs/laravel.log
echo.
echo 4. Verify PHP and Composer:
echo    php -v
echo    composer -v
echo.
echo ============================================================================
echo.
echo Press any key to close this window...
echo.
pause
exit /b 0
