# 🚀 DonateKudos Platform - Complete Setup Guide

## One-Tap Solution: Automated Setup with `setup.bat`

### Quick Start (3 Steps)

1. **Download/Clone the Repository**
   ```bash
   git clone https://github.com/ShoaibVai/donatekudos.git
   cd donatekudos
   ```

2. **Run the Setup Script**
   ```bash
   setup.bat
   ```
   
   Double-click `setup.bat` and follow the prompts!

3. **Start the Server**
   ```bash
   start-server.bat
   ```
   
   Or manually:
   ```bash
   cd laravel
   php artisan serve
   ```

4. **Access the Application**
   - Open browser: `http://127.0.0.1:8000`
   - Login with: `john@donate.com` / `password`

---

## Prerequisites (Must Install Before Running setup.bat)

### 1. Git
**Download**: https://git-scm.com/download/win

**Windows Installation**:
- Run installer
- Use default options
- Restart computer after installation

**Verify Installation**:
```bash
git --version
```

### 2. PHP (8.1 or higher)
**Download**: https://www.php.net/downloads

**Windows Installation Options**:

**Option A: Using Windows Terminal (Recommended)**
```bash
choco install php
```

**Option B: Manual Installation**
1. Download Windows ZIP from php.net
2. Extract to `C:\php`
3. Add to PATH:
   - Search: "Environment Variables"
   - Click "Edit the system environment variables"
   - Click "Environment Variables..."
   - Under "System variables", select "Path"
   - Click "Edit"
   - Click "New"
   - Add: `C:\php`
   - Click OK × 3

**Verify Installation**:
```bash
php -v
```

### 3. Composer
**Download**: https://getcomposer.org/download/

**Windows Installation**:
- Run the installer (Composer-Setup.exe)
- Accept defaults
- It automatically finds PHP
- Let it modify PATH

**Verify Installation**:
```bash
composer --version
```

### 4. Node.js (Optional, for frontend tools)
**Download**: https://nodejs.org/

**Windows Installation**:
- Run installer
- Accept default options
- Restart computer

**Verify Installation**:
```bash
node --version
npm --version
```

---

## What the `setup.bat` Script Does

### ✅ Automated Tasks

1. **Prerequisites Check**
   - Verifies Git, PHP, Composer installed
   - Checks versions and PATH
   - Fails gracefully if missing

2. **Repository Setup**
   - Clones repository if not exists
   - Pulls latest changes if exists
   - Sets working directory

3. **PHP Dependencies**
   - Runs `composer install`
   - Downloads all Laravel packages
   - Installs security updates

4. **Environment Configuration**
   - Creates `.env` file
   - Generates APP_KEY
   - Configures SQLite database

5. **Database Setup**
   - Creates SQLite database file
   - Runs all migrations
   - Sets up tables and relationships

6. **Test Data (Optional)**
   - Seeds demo users
   - Adds test profiles
   - Populates galleries

7. **Storage Setup**
   - Creates storage symlink
   - Sets up file upload directories
   - Configures permissions

8. **Node Dependencies (Optional)**
   - Installs npm packages
   - Prepares frontend tools
   - Sets up asset pipeline

9. **Optimization**
   - Clears caches
   - Optimizes autoloader
   - Prepares for development

10. **Convenience Scripts**
    - Creates `start-server.bat`
    - Creates `reset-database.bat`
    - Creates `clear-cache.bat`

---

## Setup.bat Step-by-Step Walkthrough

### Step 1: Administrator Privileges
```
[INFO] Checking administrator privileges...
```
✅ Script needs admin rights to create symlinks

### Step 2: Prerequisites Check
```
[INFO] Checking for Git...
[SUCCESS] Git found

[INFO] Checking for PHP...
[SUCCESS] PHP found: 8.4.13

[INFO] Checking for Composer...
[SUCCESS] Composer found
```
✅ All prerequisites verified

### Step 3: Repository Setup
```
[INFO] Cloning repository...
```
✅ Downloads entire project from GitHub

Or if already exists:
```
[INFO] Repository already exists
[INFO] Pulling latest changes...
```

### Step 4: PHP Dependencies
```
[INFO] Installing Composer dependencies...
This may take several minutes...
```
✅ Downloads Laravel, packages, libraries (may take 3-5 minutes)

### Step 5: Environment Configuration
```
[INFO] Creating .env file from .env.example...
[INFO] Generating application key...
[INFO] Setting database configuration...
```
✅ Creates `.env` with unique app key

### Step 6: Database Setup
```
[INFO] Creating SQLite database file...
[INFO] Running migrations...
```
✅ Creates tables for:
- Users
- Profiles
- Galleries
- Admin accounts
- Sessions/Cache

### Step 7: Seed Database (Optional)
```
Do you want to seed test data? (y/n): y
[INFO] Seeding database with test data...
```
✅ Creates test users and sample data

### Step 8: Storage Setup
```
[INFO] Creating storage symlink...
```
✅ Links `public/storage` to `storage/app/public`

### Step 9: Node Dependencies (Optional)
```
Install Node.js dependencies? (y/n): y
```
✅ For frontend asset compilation

### Step 10: Optimization
```
[INFO] Clearing caches...
[SUCCESS] Caches cleared!
```
✅ Removes old cache files

### Step 11: Verification
```
Checking key files...
 ✓ .env file exists
 ✓ Database file exists
 ✓ Storage logs directory exists
 ✓ Storage symlink exists
 ✓ Routes configured correctly
```
✅ Confirms everything set up correctly

### Step 12: Convenience Scripts
```
[SUCCESS] Created start-server.bat
[SUCCESS] Created reset-database.bat
[SUCCESS] Created clear-cache.bat
```
✅ Quick access scripts created

---

## Created Convenience Scripts

### 1. `start-server.bat`
**Purpose**: Start development server

**Usage**: Double-click or run:
```bash
start-server.bat
```

**Output**:
```
Starting DonateKudos Development Server...
Application URL: http://127.0.0.1:8000
Press Ctrl+C to stop the server
```

**Then open browser**: http://127.0.0.1:8000

### 2. `reset-database.bat`
**Purpose**: Wipe database clean and reset

**Usage**: Double-click or run:
```bash
reset-database.bat
```

**Prompts**: Asks for confirmation before deleting

**Result**: Fresh database with test data

### 3. `clear-cache.bat`
**Purpose**: Clear application caches

**Usage**: Double-click or run:
```bash
clear-cache.bat
```

**Clears**:
- Application cache
- View cache
- Config cache
- Route cache

---

## Manual Setup (If setup.bat Fails)

### If automatic setup doesn't work, follow these manual steps:

```bash
# 1. Navigate to project
cd laravel

# 2. Install dependencies
composer install

# 3. Create .env file
copy .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Create database
type nul > database\database.sqlite

# 6. Run migrations
php artisan migrate

# 7. Seed test data (optional)
php artisan db:seed

# 8. Create storage symlink
php artisan storage:link

# 9. Clear caches
php artisan cache:clear
php artisan view:clear

# 10. Start server
php artisan serve
```

---

## Test Credentials

After setup, log in with:

### Regular User
```
Email: john@donate.com
Password: password
```

### Admin (if seeded)
```
Username: admin
Password: admin
```

---

## First Time Setup Troubleshooting

### Issue 1: "Git is not installed"
**Solution**:
1. Download from: https://git-scm.com/download/win
2. Run installer
3. Accept all defaults
4. Restart Command Prompt
5. Run `setup.bat` again

### Issue 2: "PHP is not installed"
**Solution**:
1. Download from: https://www.php.net/downloads
2. Extract to `C:\php`
3. Add to Windows PATH (see Prerequisites section)
4. Restart Command Prompt
5. Run `setup.bat` again

### Issue 3: "Composer is not installed"
**Solution**:
1. Download from: https://getcomposer.org/download/
2. Run Composer-Setup.exe
3. It auto-detects PHP
4. Restart Command Prompt
5. Run `setup.bat` again

### Issue 4: "Access denied" or "Permission denied"
**Solution**:
1. Right-click Command Prompt
2. Select "Run as Administrator"
3. Run `setup.bat` again

### Issue 5: Database errors after setup
**Solution**:
1. Run: `reset-database.bat`
2. Choose "y" to reset
3. Wait for completion
4. Start server again

### Issue 6: Storage symlink not created
**Solution**:
1. Open Command Prompt as Administrator
2. Navigate to project: `cd laravel`
3. Run: `php artisan storage:link`
4. Try accessing upload features

---

## Project Structure After Setup

```
donatekudos/
├── laravel/                          ← Main application
│   ├── app/
│   │   ├── Http/Controllers/         ← Business logic
│   │   ├── Models/                   ← Database models
│   │   └── Providers/
│   ├── database/
│   │   ├── migrations/               ← Database structure
│   │   ├── seeders/                  ← Test data
│   │   └── database.sqlite           ← Database file (created)
│   ├── resources/
│   │   ├── views/                    ← Blade templates
│   │   ├── css/
│   │   └── js/
│   ├── routes/
│   │   └── web.php                   ← Routes definition
│   ├── storage/                      ← Logs, uploads
│   ├── public/
│   │   ├── index.php                 ← Entry point
│   │   └── storage/                  ← Symlink (created)
│   ├── .env                          ← Configuration (created)
│   ├── .env.example                  ← Configuration template
│   ├── composer.json                 ← PHP dependencies
│   ├── package.json                  ← Node dependencies
│   └── artisan                       ← CLI tool
├── setup.bat                         ← Setup script (created)
├── start-server.bat                  ← Start server (created)
├── reset-database.bat                ← Reset DB (created)
├── clear-cache.bat                   ← Clear cache (created)
├── COMPREHENSIVE_AUDIT_REPORT.md     ← Technical docs
├── README.md
└── README_AUDIT_INDEX.md
```

---

## After Setup - Next Steps

### 1. Start Development
```bash
# Navigate to project
cd laravel

# Start development server
php artisan serve

# Server runs at: http://127.0.0.1:8000
```

### 2. Create New User
- Go to: http://127.0.0.1:8000/auth/register
- Fill in registration form
- Follow TOTP setup with authenticator app
- Log in with created credentials

### 3. Edit Profile
- Log in with your account
- Go to: http://127.0.0.1:8000/profile/edit
- Add contact info, wallet addresses
- Upload QR code and gallery images

### 4. View Public Profile
- Your profile URL: http://127.0.0.1:8000/profile/[your-name]
- Share this with others

### 5. Admin Access
- Go to: http://127.0.0.1:8000/admin
- Log in with admin credentials
- View users and deleted users

---

## Common Tasks After Setup

### Clear Application Cache
```bash
clear-cache.bat
```
Or manually:
```bash
php artisan cache:clear
```

### Reset Database
```bash
reset-database.bat
```
Or manually:
```bash
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

### Install Node Dependencies
```bash
npm install
```

### Build Frontend Assets
```bash
npm run dev    # Development build
npm run build  # Production build
```

### View Application Logs
```
storage/logs/laravel.log
```

### Database Backups
The SQLite database file is stored at:
```
database/database.sqlite
```
Simply copy this file to backup!

---

## Development Tips

### Enable Debug Mode
Edit `.env`:
```
APP_DEBUG=true
```

### Change Server Port
```bash
php artisan serve --port=8001
```

### Database Migrations
Create new migration:
```bash
php artisan make:migration create_table_name
```

Run specific migration:
```bash
php artisan migrate --path=/database/migrations/[file]
```

### Clear All Caches
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

---

## System Requirements Summary

| Requirement | Version | Status |
|-------------|---------|--------|
| Windows | 10/11 | ✅ Required |
| PHP | 8.1+ | ✅ Required |
| Composer | Latest | ✅ Required |
| Git | Latest | ✅ Required |
| Node.js | 14+ | ⭕ Optional |
| SQLite | Built-in | ✅ Included |

---

## Important Paths

```
Project Root:
  d:\Documents\Projects\donatekudos

Application Root:
  d:\Documents\Projects\donatekudos\laravel

Public Folder (web access):
  d:\Documents\Projects\donatekudos\laravel\public

Database:
  d:\Documents\Projects\donatekudos\laravel\database\database.sqlite

Uploads:
  d:\Documents\Projects\donatekudos\laravel\storage\app\public

Logs:
  d:\Documents\Projects\donatekudos\laravel\storage\logs
```

---

## Final Checklist

After running setup, verify:

- [ ] setup.bat ran without errors
- [ ] All 3 convenience scripts created
- [ ] Database file exists
- [ ] Storage symlink created
- [ ] start-server.bat works
- [ ] Can access http://127.0.0.1:8000
- [ ] Can log in with test credentials
- [ ] No errors in storage/logs/laravel.log

✅ If all checked - Setup is complete and working!

---

## Support & Documentation

For more detailed information, see:
- **COMPREHENSIVE_AUDIT_REPORT.md** - Technical deep-dive
- **FINAL_AUDIT_APPROVAL.md** - Production notes
- **README.md** - Project overview

---

## Quick Reference - Commands

```bash
# Server management
php artisan serve                    # Start dev server
php artisan serve --port=8001       # Start on port 8001

# Database
php artisan migrate                  # Run migrations
php artisan migrate:reset            # Reset migrations
php artisan db:seed                  # Seed test data
php artisan tinker                   # Interactive shell

# Cache & Optimization
php artisan cache:clear              # Clear cache
php artisan view:clear               # Clear views
php artisan config:clear             # Clear config
php artisan route:clear              # Clear routes
php artisan storage:link             # Create symlink

# Development
php artisan make:controller Name     # Generate controller
php artisan make:model Name          # Generate model
php artisan make:migration name      # Generate migration

# Utilities
php artisan route:list               # List all routes
php artisan config:show              # Show configuration
php artisan env                      # Show environment
```

---

**Setup Guide Version**: 1.0  
**Last Updated**: November 12, 2025  
**Compatible With**: Windows 10/11  
**Status**: ✅ Production Ready

