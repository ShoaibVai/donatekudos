# Laravel Supabase Profile Manager

A comprehensive user profile management system with TOTP authentication, admin panel, and data archival features built with Laravel 10.x and Supabase.

## Features

- **User Authentication**: Supabase Auth with email/password
- **Profile Management**: User profiles with custom data (contact info, wallet addresses)
- **Gallery System**: Image uploads and management with Supabase Storage
- **2FA/TOTP**: Two-factor authentication with TOTP
- **Admin Panel**: Admin dashboard with user management and XML export
- **Data Archival**: Profile deletion with data archival for 30 days
- **Public Profiles**: Shareable user profiles with public API endpoint
- **Responsive UI**: Tailwind CSS for modern, mobile-friendly design

## Tech Stack

- **Backend**: Laravel 10.x
- **Database**: Supabase (PostgreSQL)
- **Authentication**: Supabase Auth
- **Storage**: Supabase Storage
- **Frontend**: Blade Templates + Tailwind CSS
- **Testing**: PHPUnit

## Installation

### Prerequisites

- PHP 8.1+
- Composer
- Node.js & npm
- Supabase Account

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Configure environment variables**
   
   Copy `.env.example` to `.env` and update with your Supabase credentials:
   ```bash
   cp .env.example .env
   ```

   Update the following in `.env`:
   ```
   SUPABASE_URL=https://your-project.supabase.co
   SUPABASE_KEY=your-anon-key
   SUPABASE_SERVICE_ROLE_KEY=your-service-role-key
   SUPABASE_STRIPE_PUBLISHABLE_KEY=your-stripe-key
   SUPABASE_STRIPE_SECRET_KEY=your-stripe-secret
   ```

5. **Generate Laravel App Key**
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Database Schema

### Tables

#### `profiles`
- **id**: UUID (Primary Key)
- **user_id**: UUID (Foreign Key → auth.users)
- **username**: String (Unique)
- **bio**: Text
- **avatar_url**: String
- **contact_info**: JSONB (email, phone, address, etc.)
- **wallet_addresses**: JSONB (Array of crypto wallets)
- **qr_code_url**: String
- **timestamps**: created_at, updated_at

#### `galleries`
- **id**: UUID (Primary Key)
- **profile_id**: UUID (Foreign Key → profiles)
- **image_url**: String
- **filename**: String
- **file_size**: Integer
- **mime_type**: String
- **timestamps**: created_at, updated_at

#### `archived_profiles`
- **id**: UUID (Primary Key)
- **original_profile_id**: UUID
- **user_id**: UUID
- **user_data**: JSONB (Complete profile snapshot)
- **gallery_data**: JSONB (Gallery snapshot)
- **deleted_at**: Timestamp
- **expires_at**: Timestamp (30 days)

#### `recovery_tokens`
- **id**: UUID (Primary Key)
- **user_id**: UUID (Unique, Foreign Key → auth.users)
- **token**: String (TOTP secret)
- **is_enabled**: Boolean
- **is_verified**: Boolean
- **timestamps**: created_at, updated_at

## API Routes

### Public Routes
- `GET /` - Home page
- `GET /profile/{username}` - Public profile display
- `GET /api/profile/{username}` - Public profile JSON API

### Authenticated Routes
- `GET /dashboard` - User dashboard
- `GET /profile/edit` - Edit profile form
- `POST /profile/update` - Update profile
- `POST /profile/delete` - Delete/archive profile
- `GET /profile/gallery` - Gallery management
- `POST /gallery/upload` - Upload image
- `DELETE /gallery/{id}` - Delete image
- `POST /2fa/enable` - Enable 2FA
- `POST /2fa/verify` - Verify 2FA
- `POST /2fa/disable` - Disable 2FA

### Admin Routes
- `GET /admin` - Admin login form
- `POST /admin` - Admin login
- `POST /admin/logout` - Admin logout
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/users` - List all users
- `GET /admin/users/{id}` - View user details
- `GET /admin/export/xml` - Export data as XML

## Authentication

### User Registration
1. Register via Supabase Auth
2. TOTP secret generated and displayed
3. Profile record created automatically

### Admin Authentication
- Access `/admin` with password: `Rishbish$$`
- Session-based authentication
- Accessible only from admin login

## File Storage Structure

### Supabase Storage Buckets

#### `qr-codes` (Public)
```
qr-codes/
└── public/
    └── qrcodes/
        └── {user_id}.{ext}
```

#### `profile-galleries` (Public)
```
profile-galleries/
└── public/
    └── galleries/
        └── {profile_id}/
            └── {filename}
```

## Testing

### Run all tests
```bash
php artisan test
```

### Run specific test class
```bash
php artisan test tests/Unit/ProfileCreationTest
php artisan test tests/Unit/GalleryManagementTest
php artisan test tests/Unit/ProfileArchivalTest
php artisan test tests/Unit/RecoveryTokenTest
```

### Tests Included
- Profile creation with valid data
- Profile uniqueness validation
- JSON data storage in JSONB fields
- Gallery cascade deletion
- Profile archival on deletion
- 30-day expiration for archived profiles
- TOTP token management
- 2FA enable/disable functionality

## Security Considerations

### Implemented
- ✅ HTTPS enforcement (production)
- ✅ CSRF protection (Laravel middleware)
- ✅ XSS prevention (Blade escaping)
- ✅ SQL injection protection (Eloquent ORM)
- ✅ Password hashing (bcrypt)
- ✅ Secure session handling
- ✅ TOTP secrets never exposed in responses
- ✅ Admin password hashing
- ✅ Cascade deletion of related data

### Recommended
- Implement rate limiting on login endpoints
- Add email verification requirement
- Enable CORS restrictions
- Use Redis for session management in production
- Implement audit logging for admin actions
- Add request validation and sanitization
- Encrypt sensitive JSONB fields

## Production Deployment

### Pre-deployment Checklist
- [ ] Environment variables configured
- [ ] Database migrations run
- [ ] SSL certificate installed
- [ ] Admin password changed
- [ ] Rate limiting configured
- [ ] Monitoring setup (error tracking, logs)
- [ ] Backup strategy implemented
- [ ] Cache configuration optimized
- [ ] Queue workers configured

### Environment Configuration
```bash
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=pgsql
CACHE_DRIVER=redis
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

### Build and Deploy
```bash
composer install --no-dev --optimize-autoloader
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

## Models

### Profile
- Relationship: `hasMany` with Gallery
- Fillable: username, bio, avatar_url, contact_info, wallet_addresses, qr_code_url
- Casts: contact_info and wallet_addresses as arrays

### Gallery
- Relationship: `belongsTo` Profile
- Fillable: profile_id, image_url, filename, file_size, mime_type

### ArchivedProfile
- No timestamps (deleted_at is manual)
- Stores complete snapshot of user data
- 30-day retention period

### RecoveryToken
- Hidden: token field (not exposed in JSON responses)
- One-to-one relationship with users
- Manages TOTP secrets

## Controllers

### ProfileController
- `dashboard()` - User dashboard
- `show()` - Public profile display
- `edit()` - Profile edit form
- `update()` - Update profile
- `destroy()` - Archive and delete profile

### GalleryController
- `manage()` - Gallery management page
- `upload()` - Upload new image
- `destroy()` - Delete image

### TwoFactorController
- `enable()` - Enable 2FA
- `verify()` - Verify and save 2FA
- `disable()` - Disable 2FA

### Admin\DashboardController
- `index()` - Admin dashboard

### Admin\UserController
- `index()` - List all users
- `show()` - View user details

### Admin\ExportController
- `xml()` - Export data as XML

## Troubleshooting

### Migration Issues
If migrations fail, ensure:
- Supabase database is accessible
- Foreign key constraints are properly defined
- UUID extension is enabled in PostgreSQL

### Authentication Issues
- Check Supabase Auth credentials in `.env`
- Verify SUPABASE_URL and SUPABASE_KEY are correct
- Clear session and try again

### File Upload Issues
- Verify Supabase Storage bucket exists
- Check storage permissions
- Ensure file size is under 5MB

## License

This project is licensed under the MIT License.

## Support

For issues and feature requests, please open an issue on the repository.
