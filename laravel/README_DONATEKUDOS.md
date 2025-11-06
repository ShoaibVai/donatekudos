# DonateKudos - Laravel Project

A secure, full-featured Laravel application with two-factor authentication (2FA), user profile management, and admin panel for user and data management.

## Features

✅ **User Authentication with TOTP (Two-Factor Authentication)**
- Google Authenticator compatible  
- Recovery tokens for account recovery
- Secure password hashing

✅ **User Profile Management**
- Create and edit user profiles
- Store contact information and wallet addresses
- Upload QR codes and gallery images
- Public profile pages

✅ **Profile Deletion**
- Soft delete with data archiving
- Automatic migration to deleted tables
- User logout on deletion

✅ **Admin Panel**
- User management dashboard
- View active users
- View deleted users archive
- Export user data to XML

✅ **SEO Optimization**
- Proper meta tags
- Clean URLs
- Semantic HTML

## Technology Stack

- **Framework**: Laravel 12.0
- **PHP Version**: 8.2+
- **Database**: MySQL
- **Authentication**: TOTP (pragmarx/google2fa)
- **QR Code**: bacon/bacon-qr-code
- **Server**: XAMPP / Apache

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL/MariaDB
- Git

### Step 1: Clone the Repository

```bash
cd path/to/laravel
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=donatekudos
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Database Migration

```bash
php artisan migrate
```

This will create the following tables:
- `users` - Main user table with TOTP secret
- `deleted_users` - Archive of deleted users
- `profiles` - User profile information
- `deleted_profiles` - Archive of deleted profiles
- `galleries` - User gallery images
- `deleted_galleries` - Archive of deleted galleries
- `admins` - Admin users

**Default Admin Credentials:**
- Username: `admin`
- Password: `Rishbish$$`

### Step 5: File Storage

```bash
php artisan storage:link
```

This creates the storage symlink for public file uploads.

### Step 6: Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── RegisterController.php
│   │   │   ├── LoginController.php
│   │   │   └── ForgotPasswordController.php
│   │   ├── ProfileController.php
│   │   └── AdminController.php
├── Models/
│   ├── User.php
│   ├── Profile.php
│   ├── Gallery.php
│   ├── Admin.php
│   ├── DeletedUser.php
│   ├── DeletedProfile.php
│   └── DeletedGallery.php
database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000003_create_deleted_users_table.php
│   ├── 0001_01_01_000004_create_profiles_table.php
│   ├── 0001_01_01_000005_create_deleted_profiles_table.php
│   ├── 0001_01_01_000006_create_galleries_table.php
│   ├── 0001_01_01_000007_create_deleted_galleries_table.php
│   └── 0001_01_01_000008_create_admins_table.php
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── auth/
│   │   ├── register.blade.php
│   │   ├── login.blade.php
│   │   ├── totp-setup.blade.php
│   │   ├── verify-totp.blade.php
│   │   └── passwords/
│   │       ├── email.blade.php
│   │       ├── reset.blade.php
│   │       └── reset-done.blade.php
│   ├── profile/
│   │   ├── index.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   └── admin/
│       ├── login.blade.php
│       ├── dashboard.blade.php
│       ├── users.blade.php
│       └── deleted-users.blade.php
routes/
└── web.php
```

## Usage

### User Registration

1. Click "Register" on the home page
2. Enter name, email, and password
3. Scan the displayed QR code with Google Authenticator, Authy, or similar app
4. Enter the 6-digit code to confirm
5. You're ready to log in!

### User Login

1. Go to Login page
2. Enter email and password
3. Enter the 6-digit code from your authenticator app
4. Access your profile

### Password Reset

1. Click "Forgot your password?" on login page
2. Enter your email and recovery token (TOTP secret from registration)
3. Enter your new password
4. A new TOTP secret will be generated - save it securely

### Profile Management

1. Log in to your account
2. Click "Profile" to view your profile
3. Click "Edit Profile" to:
   - Update contact information (JSON format)
   - Update wallet addresses (JSON format)
   - Upload a QR code image
   - Upload gallery images

### Account Deletion

1. Go to Profile > Edit Profile
2. Scroll to "Danger Zone"
3. Click "Delete My Account"
4. Confirm the deletion
5. Your account and data will be archived in the system

### Admin Panel

1. Go to `/admin`
2. Log in with admin credentials
3. Access the dashboard to:
   - View user statistics
   - Manage active users
   - View deleted users
   - Export user data to XML

## Database Schema

### Users Table
```sql
- id (bigint, primary key)
- name (string)
- email (string, unique)
- password (string)
- totp_secret (string, nullable)
- remember_token (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### Profiles Table
```sql
- id (bigint, primary key)
- user_id (bigint, foreign key, unique)
- contact_info (json, nullable)
- wallet_addresses (json, nullable)
- qr_code_path (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

### Galleries Table
```sql
- id (bigint, primary key)
- user_id (bigint, foreign key)
- image_path (string)
- created_at (timestamp)
- updated_at (timestamp)
```

### Deleted Users, Profiles, and Galleries Tables
Similar to their active counterparts, with an additional `deleted_at` timestamp field.

## API Routes

### Authentication Routes
- `POST /auth/register` - User registration
- `POST /auth/totp-confirm` - Confirm TOTP setup
- `POST /auth/login` - User login
- `POST /auth/verify-totp` - Verify TOTP code
- `POST /auth/logout` - User logout
- `POST /auth/password/reset` - Request password reset
- `POST /auth/password/reset/confirm` - Confirm new password

### Profile Routes (Authenticated)
- `GET /profile` - View current user profile
- `GET /profile/edit` - Edit profile form
- `PUT /profile` - Update profile
- `DELETE /profile` - Delete account
- `GET /profile/{username}` - View public profile

### Admin Routes (Admin Auth Required)
- `POST /admin/login` - Admin login
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/users` - List active users
- `GET /admin/users/{user}/export/xml` - Export user data
- `GET /admin/deleted-users` - List deleted users
- `POST /admin/logout` - Admin logout

## Security Features

✅ CSRF Protection - All forms protected with CSRF tokens
✅ TOTP 2FA - Industry-standard two-factor authentication
✅ Password Hashing - bcrypt hashing via Laravel
✅ SQL Injection Prevention - Eloquent ORM protects queries
✅ XSS Protection - Blade template escaping
✅ Session Management - Secure session handling
✅ Admin Authentication - Separate admin guard

## Production Deployment

### Environment Setup

```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Generate application key (if not already done)
php artisan key:generate

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database

```bash
# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link
```

### File Permissions

```bash
# Set proper permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Web Server Configuration

**Apache (.htaccess already configured):**
- Enable `mod_rewrite`
- Ensure document root points to `public/`

**Nginx:**
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### SSL Certificate

Use Let's Encrypt or your SSL provider to enable HTTPS.

## Testing

Run feature tests:
```bash
php artisan test
```

Run specific test:
```bash
php artisan test --filter=UserRegistrationTest
```

## Troubleshooting

### TOTP Secret Not Displaying
- Ensure `bacon/bacon-qr-code` is installed
- Check session storage is working

### Profile Images Not Loading
- Verify storage link exists: `php artisan storage:link`
- Check file permissions in `storage/app/public`

### Admin Login Failed
- Verify admin user exists: `SELECT * FROM admins;`
- Check password hashing

### Database Connection Error
- Verify `.env` database credentials
- Ensure MySQL is running
- Check database exists

## Contributing

1. Create a feature branch
2. Make your changes
3. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For issues and questions, please create an issue in the repository.

---

**Last Updated:** November 6, 2025
