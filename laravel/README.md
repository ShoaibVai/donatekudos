# DonateKudos - Authentication System with TOTP

A complete authentication system built with Laravel featuring user registration, login, and forgot password functionality with TOTP (Time-based One-Time Password) verification.

## 🎯 Quick Overview

- ✅ User Registration with validation
- ✅ User Login with "Remember Me"
- ✅ Forgot Password with TOTP verification
- ✅ Database sessions
- ✅ CSRF protection
- ✅ Bcrypt password hashing
- ✅ SQLite (dev) / PostgreSQL Supabase (prod)

## 🚀 Quick Start

```bash
cd d:\Documents\Projects\donatekudos\laravel

# Install dependencies
composer install

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Start server
php artisan serve
```

Access at: **http://127.0.0.1:8000**

## 📚 Documentation

| Document | Purpose |
|----------|---------|
| **QUICKSTART.md** | Get started quickly |
| **AUTHENTICATION.md** | Complete feature documentation |
| **API_DOCUMENTATION.md** | Endpoint reference |
| **SUPABASE_SETUP.md** | PostgreSQL/Supabase setup |
| **TESTING_CHECKLIST.md** | Testing guide |
| **COMMANDS_REFERENCE.md** | Artisan commands |

## 🔗 Key Routes

### Public
- `GET /` - Home
- `GET /signup` - Sign up form
- `POST /signup` - Register
- `GET /login` - Login form
- `POST /login` - Authenticate
- `GET /forgot-password` - Reset request
- `POST /forgot-password` - Start reset
- `GET /verify-totp-forgot` - TOTP verification
- `POST /verify-totp-forgot` - Verify code
- `GET /reset-password` - New password form
- `POST /reset-password` - Update password

### Protected
- `GET /dashboard` - User dashboard
- `POST /logout` - Sign out

## 🔐 Features

### Sign Up
- Email validation
- Unique email check
- Password confirmation
- Auto-login after signup

### Login
- Credential authentication
- Remember me option
- Session management

### Forgot Password
- Email verification
- TOTP secret generation
- Code validation
- Secure password reset

### Security
- Bcrypt hashing (12 rounds)
- TOTP 2FA
- CSRF protection
- SQL injection prevention
- XSS protection

## 🛠️ Tech Stack

- **Laravel 11** - Web framework
- **PHP 8.2+** - Language
- **SQLite** - Dev database
- **PostgreSQL** - Production (Supabase)
- **Blade** - Templating
- **Tailwind CSS** - Styling
- **OTPHP** - TOTP library

## 📦 Installation

### Prerequisites
- PHP 8.2+
- Composer
- SQLite (built-in)

### Setup

1. Install deps: `composer install`
2. Generate key: `php artisan key:generate`
3. Migrate: `php artisan migrate`
4. Serve: `php artisan serve`

## 🧪 Quick Test

1. Go to `/signup` and create account
2. Go to `/login` and sign in
3. Go to `/forgot-password` to test TOTP reset
4. Use authenticator app (Google Authenticator, Authy)

## ⚙️ Configuration

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
3. Run: `php artisan migrate`

See **SUPABASE_SETUP.md** for details.

## 📖 Usage

### Create Account
```
/signup → Enter details → Auto-logged in → Dashboard
```

### Login
```
/login → Enter email/password → Dashboard
```

### Reset Password
```
/forgot-password → Email verification → TOTP code → New password → Login
```

## 🐛 Troubleshooting

Clear cache:
```bash
php artisan cache:clear && php artisan config:clear
```

Fresh database:
```bash
php artisan migrate:fresh
```

## 📞 Support

- See **QUICKSTART.md** for quick reference
- See **TESTING_CHECKLIST.md** for testing
- See **COMMANDS_REFERENCE.md** for commands
- Check Laravel docs: https://laravel.com/docs

## ✅ Status

- ✅ Authentication implemented
- ✅ TOTP integrated
- ✅ Database configured
- ✅ All routes working
- ✅ Documentation complete
- ✅ Ready for testing & deployment

**Last Updated**: November 4, 2025

For more information, see the detailed documentation files included in the project.

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
