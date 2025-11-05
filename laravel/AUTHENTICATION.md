# Authentication System with TOTP for Password Reset

This is a complete authentication system built with Laravel featuring user registration, login, and forgot password flow with Time-based One-Time Password (TOTP) verification.

## Features

- **User Registration**: Create new user accounts with email and password
- **User Login**: Sign in with email and password
- **Forgot Password**: Request password reset with TOTP verification
- **TOTP Verification**: Two-factor authentication using authenticator apps (Google Authenticator, Authy, etc.)
- **Password Reset**: Change password after TOTP verification
- **Session Management**: Automatic logout and session cleanup

## Technology Stack

- **Framework**: Laravel 11
- **Database**: SQLite (development) / PostgreSQL with Supabase (production)
- **TOTP Library**: spomky-labs/otphp
- **Frontend**: Blade templates with Tailwind CSS
- **Authentication**: Laravel's built-in authentication system

## Setup Instructions

### Prerequisites

- PHP 8.2 or higher
- Composer
- PostgreSQL driver for production (optional)

### Installation

1. **Clone or navigate to the project**
```bash
cd d:\Documents\Projects\donatekudos\laravel
```

2. **Install dependencies**
```bash
composer install
```

3. **Generate application key**
```bash
php artisan key:generate
```

4. **Run migrations**
```bash
php artisan migrate
```

5. **Start the development server**
```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

## Configuration

### Environment Variables

Update `.env` file with your configuration:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration (SQLite for development)
DB_CONNECTION=sqlite

# For Supabase PostgreSQL (production)
# DB_CONNECTION=pgsql
# DB_HOST=db.idfjadtzqobtucxqkcuy.supabase.co
# DB_PORT=5432
# DB_DATABASE=postgres
# DB_USERNAME=postgres
# DB_PASSWORD=your_password
```

### Supabase PostgreSQL Setup

To use Supabase PostgreSQL in production:

1. Install PHP PostgreSQL driver (PDO):
   - **On Windows**: Uncomment `extension=pdo_pgsql` in `php.ini`
   - **On Linux**: `sudo apt-get install php-pgsql`
   - **On macOS**: `brew install php@8.2-pgsql`

2. Update `.env` with Supabase credentials from `credentials.txt`

3. Run migrations again with PostgreSQL connection

## Authentication Routes

### Public Routes
- `GET /` - Welcome page
- `GET /signup` - Sign up form
- `POST /signup` - Register new user
- `GET /login` - Login form
- `POST /login` - Authenticate user
- `GET /forgot-password` - Forgot password form
- `POST /forgot-password` - Request password reset
- `GET /verify-totp-forgot` - TOTP verification form
- `POST /verify-totp-forgot` - Verify TOTP code
- `GET /reset-password` - Reset password form
- `POST /reset-password` - Update password

### Protected Routes
- `GET /dashboard` - User dashboard (requires authentication)
- `POST /logout` - Sign out user

## File Structure

```
app/
├── Http/
│   └── Controllers/
│       └── Auth/
│           ├── SignUpController.php
│           ├── LoginController.php
│           ├── ForgotPasswordController.php
│           └── ResetPasswordController.php
├── Models/
│   └── User.php (with TOTP support)
└── Providers/
    └── AppServiceProvider.php

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000001_create_cache_table.php
│   ├── 0001_01_01_000002_create_jobs_table.php
│   └── 2025_11_04_000003_add_totp_to_users.php
└── seeders/
    └── DatabaseSeeder.php

resources/
└── views/
    ├── layouts/
    │   └── app.blade.php
    ├── auth/
    │   ├── signup.blade.php
    │   ├── login.blade.php
    │   ├── forgot-password.blade.php
    │   ├── verify-totp-forgot.blade.php
    │   └── reset-password.blade.php
    ├── dashboard.blade.php
    └── welcome.blade.php

routes/
└── web.php
```

## User Model

The `User` model has been extended to support TOTP:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'totp_secret',  // TOTP secret for password reset
];

protected $hidden = [
    'password',
    'remember_token',
    'totp_secret',
];
```

## Authentication Flow

### Sign Up
1. User fills signup form with name, email, and password
2. System validates input and creates new user
3. User is automatically logged in
4. Redirects to dashboard

### Login
1. User enters email and password
2. System verifies credentials
3. User session is created
4. Redirects to dashboard with optional "Remember me"

### Forgot Password Flow
1. User enters email address
2. System generates TOTP secret
3. User is shown the TOTP secret
4. User scans QR code or enters secret in authenticator app
5. User enters 6-digit TOTP code
6. System verifies TOTP code
7. User is prompted to enter new password
8. Password is updated
9. User is redirected to login page

## TOTP Setup

### How TOTP Works

1. **Secret Generation**: When user initiates password reset, a unique TOTP secret is generated
2. **Authenticator Setup**: User adds the secret to their authenticator app
3. **Code Generation**: Authenticator app generates 6-digit codes every 30 seconds
4. **Verification**: User enters code to verify ownership of account

### Recommended Authenticator Apps

- **Google Authenticator** (iOS, Android)
- **Microsoft Authenticator** (iOS, Android)
- **Authy** (iOS, Android, Desktop)
- **1Password** (iOS, Android, Desktop)
- **FreeOTP** (iOS, Android, Open Source)

## Session Management

Sessions are stored in the database and configured via `.env`:

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120  # Session timeout in minutes
```

## Error Handling

The system provides user-friendly error messages:

- **Invalid credentials**: "The provided credentials do not match our records."
- **Invalid TOTP**: "The TOTP code is invalid."
- **Session expired**: "Session expired. Please try again."
- **Email not found**: "Email not found in our database."

## Security Features

- Passwords are hashed using Laravel's bcrypt
- TOTP secrets are stored securely
- Session CSRF protection via `@csrf` directive
- Input validation on all forms
- SQL injection protection via Eloquent ORM
- XSS protection via Blade template escaping

## Testing

To test the authentication flow:

1. **Sign Up**: Visit `/signup` and create a new account
2. **Login**: Visit `/login` with your credentials
3. **Forgot Password**: Visit `/forgot-password` and enter your email
4. **TOTP Verification**: Use an authenticator app to get the code
5. **Reset Password**: Enter new password after TOTP verification

## Troubleshooting

### Database Migration Failed
```bash
# Fresh database (warning: deletes all data)
php artisan migrate:fresh

# Specific migration
php artisan migrate --path=database/migrations/2025_11_04_000003_add_totp_to_users.php
```

### Clear Application Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Recreate Application Key
```bash
php artisan key:generate
```

## Production Deployment

### Switch to PostgreSQL

1. Install PHP PostgreSQL driver
2. Update `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=db.idfjadtzqobtucxqkcuy.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your_password
```
3. Run migrations
4. Deploy application

### Environment Configuration

```env
APP_ENV=production
APP_DEBUG=false
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## Support

For issues or questions, refer to:
- [Laravel Documentation](https://laravel.com/docs)
- [OATHP Library](https://github.com/Spomky-Labs/otphp)
- [Supabase Documentation](https://supabase.com/docs)

## License

This project is open-source software licensed under the MIT license.
