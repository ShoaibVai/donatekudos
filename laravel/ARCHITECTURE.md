# DonateKudos - Architecture & Configuration Guide

## Authentication Architecture

### Dual Guard System

The application implements two separate authentication guards:

#### 1. Web Guard (Users)
- **Location**: `config/auth.php` → `guards.web`
- **Provider**: `users` (User model)
- **Usage**: Regular user login/logout
- **Middleware**: `auth` (or `auth:web`)
- **Routes**: `/auth/login`, `/profile`, etc.

#### 2. Admin Guard
- **Location**: `config/auth.php` → `guards.admin`
- **Provider**: `admins` (Admin model)
- **Usage**: Admin panel access
- **Middleware**: `auth:admin`
- **Routes**: `/admin/dashboard`, `/admin/users`, etc.

### Implementation

```php
// config/auth.php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
]
```

## TOTP Implementation

### How It Works

1. **Registration Flow**
   ```
   User enters credentials
   ↓
   Server generates secret (random 32-char string)
   ↓
   QR code generated from secret
   ↓
   User scans with authenticator app
   ↓
   User enters 6-digit code
   ↓
   Server verifies code against secret
   ↓
   Secret stored in users.totp_secret
   ```

2. **Login Flow**
   ```
   User enters email/password
   ↓
   Password verified
   ↓
   User directed to TOTP verification
   ↓
   User enters 6-digit code from app
   ↓
   Code verified against users.totp_secret
   ↓
   User logged in
   ```

3. **Recovery Flow**
   ```
   User enters email + recovery token (totp_secret)
   ↓
   Token validated
   ↓
   User enters new password
   ↓
   New TOTP secret generated
   ↓
   New secret displayed as QR code
   ↓
   User must scan new code in authenticator app
   ```

### Google2FA Package

The project uses `pragmarx/google2fa` which provides:
- `generateSecretKey()` - Generate random TOTP secret
- `getQRCodeUrl()` - Generate QR code URL
- `verifyKey()` - Verify 6-digit code against secret

### Session Storage for TOTP Setup

During registration, the TOTP setup uses session:
```php
session(['totp_secret' => $secret, 'qr_code_url' => $qrCodeUrl]);
```

This allows the user to:
- See the QR code
- Enter the verification code
- Confirm setup before login

## Profile Management

### Relationships

```
User (1)
  ├── Profile (1)
  │   ├── contact_info (JSON)
  │   ├── wallet_addresses (JSON)
  │   └── qr_code_path (file)
  │
  ├── Galleries (Many)
  │   └── image_path (files)
  │
  └── [When deleted]
      ├── DeletedUser
      ├── DeletedProfile
      └── DeletedGalleries
```

### Profile Deletion Process

```php
DB::transaction(function () {
    // 1. Create archive records
    DeletedUser::create($userData);
    DeletedProfile::create($profileData);
    DeletedGallery::create($galleryData);
    
    // 2. Delete main user (cascades to Profile, Gallery)
    $user->delete();
    
    // 3. Logout user
    Auth::logout();
});
```

This ensures:
- No orphaned data
- User data preserved in archive
- Clean separation between active and deleted users

## Admin Panel Architecture

### Authorization

The admin controller implements a simple authorization check:

```php
protected function authorizeAdmin()
{
    if (!Auth::guard('admin')->check()) {
        abort(403, 'Unauthorized. Admin access required.');
    }
}
```

This is called in critical methods to ensure admin authentication.

### XML Export

Generates XML for individual users:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<user>
    <id>1</id>
    <name>John Doe</name>
    <email>john@example.com</email>
    <status>active</status>
    <profile>
        <contact_info>{"phone":"+1234567890"}</contact_info>
        <wallet_addresses>{"bitcoin":"1A1z7agoat"}</wallet_addresses>
        <qr_code_path>qr-codes/1.png</qr_code_path>
    </profile>
    <galleries>
        <image>galleries/1-image1.png</image>
        <image>galleries/1-image2.png</image>
    </galleries>
</user>
```

## File Storage Structure

```
storage/
└── app/
    ├── public/
    │   ├── qr-codes/
    │   │   ├── user-1-qr.png
    │   │   ├── user-2-qr.png
    │   │   └── ...
    │   ├── galleries/
    │   │   ├── user-1-gallery-1.png
    │   │   ├── user-1-gallery-2.png
    │   │   ├── user-2-gallery-1.png
    │   │   └── ...
    │   └── [other public files]
    └── [private storage]
```

Public files are accessible at `/storage/qr-codes/` and `/storage/galleries/`

## Route Organization

### Authentication Routes (`/auth/*`)
- Registration: `GET /auth/register`, `POST /auth/register`
- Login: `GET /auth/login`, `POST /auth/login`
- TOTP: `GET /auth/totp-setup`, `POST /auth/totp-confirm`
- TOTP Verify: `GET /auth/verify-totp`, `POST /auth/verify-totp`
- Logout: `POST /auth/logout`
- Password Reset: Multiple endpoints under `/auth/password/*`

### Profile Routes (`/profile/*`)
- All authenticated with `middleware('auth')`
- User: Own profile, edit, update, delete
- Public: View any user's public profile by username

### Admin Routes (`/admin/*`)
- Login: `GET /admin`, `POST /admin/login`
- Dashboard: `GET /admin/dashboard` (requires `auth:admin`)
- Users: `GET /admin/users`, `GET /admin/users/{id}/export/xml`
- Deleted Users: `GET /admin/deleted-users`
- Logout: `POST /admin/logout`

## Middleware

### Built-in Laravel Middleware
- `auth` - Require user authentication
- `auth:admin` - Require admin authentication
- `guest` - Require non-authenticated user
- `web` - Web middleware stack (CSRF, cookies, etc.)

### Custom Middleware (if needed)
Can be added to validate specific actions or check user permissions.

## Database Integrity

### Foreign Keys
- `profiles.user_id` → `users.id` (onDelete: cascade)
- `galleries.user_id` → `users.id` (onDelete: cascade)

This ensures:
- Deleting a user automatically deletes their profile and gallery
- No orphaned records
- Data consistency

### Indexes
- `users.email` - Unique index for fast lookups
- `profiles.user_id` - Unique, for 1:1 relationship
- `galleries.user_id` - For 1:many relationship
- `admins.username` - Unique index for admin login

## Session Management

- **Driver**: Default (file, or Redis/Memcached)
- **Lifetime**: 120 minutes (configurable in `config/session.php`)
- **Timeout**: No timeout, uses last activity time

For TOTP temporary data:
```php
session(['login_user_id' => $user->id]); // For TOTP verification
session()->forget('login_user_id');      // After login
```

## Security Considerations

### Implemented

✅ Password hashing with bcrypt
✅ CSRF protection on all forms
✅ TOTP 2FA for user accounts
✅ SQL injection prevention (Eloquent ORM)
✅ XSS protection (Blade escaping)
✅ Secure session handling
✅ Separate admin authentication

### Recommendations

1. **Enable HTTPS** in production
2. **Use environment variables** for sensitive config
3. **Add rate limiting** to login endpoints
4. **Log authentication** failures
5. **Implement audit trails** for admin actions
6. **Add IP whitelisting** for admin access
7. **Set secure cookies**: `SESSION_SECURE_COOKIES=true`
8. **Use Redis** for sessions in production

## Configuration Files

### Key Configuration Files
- `config/auth.php` - Authentication configuration (dual guards)
- `config/app.php` - Application settings
- `config/database.php` - Database connection
- `config/filesystems.php` - File storage (public disk for files)
- `config/session.php` - Session configuration

### Environment Variables (.env)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=donatekudos
DB_USERNAME=root
DB_PASSWORD=

APP_NAME=DonateKudos
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

SESSION_DRIVER=file
```

## Performance Optimization

### For Production

1. **Cache Configuration**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Database Optimization**
   - Add indexes on frequently queried columns ✅ (done)
   - Use eager loading: `User::with('profile', 'galleries')`
   - Consider pagination for large datasets

3. **File Uploads**
   - Validate file size
   - Compress images before storage
   - Use CDN for static files

4. **TOTP Performance**
   - QR code generation is relatively fast
   - Consider caching QR code URL temporarily

---

**Architecture is production-ready!** 🚀

All guards, relationships, and security measures are in place.
