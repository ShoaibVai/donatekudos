# Quick Start Guide

## Running the Application

### 1. Start the Server

```bash
cd d:\Documents\Projects\donatekudos\laravel
php artisan serve
```

Server will run at: `http://127.0.0.1:8000`

### 2. Access the Application

- **Home**: http://127.0.0.1:8000/
- **Sign Up**: http://127.0.0.1:8000/signup
- **Login**: http://127.0.0.1:8000/login
- **Forgot Password**: http://127.0.0.1:8000/forgot-password

## Testing the Authentication

### Create a New Account

1. Go to `/signup`
2. Enter details:
   - Name: John Doe
   - Email: john@example.com
   - Password: SecurePass123
   - Confirm: SecurePass123
3. Click "Sign Up"
4. You'll be automatically logged in and redirected to dashboard

### Test Login

1. Go to `/logout` (via dashboard)
2. Go to `/login`
3. Enter credentials:
   - Email: john@example.com
   - Password: SecurePass123
4. Check "Remember me" (optional)
5. Click "Sign in"

### Test Forgot Password with TOTP

1. Go to `/forgot-password`
2. Enter email: john@example.com
3. Click "Continue"
4. You'll see a TOTP secret displayed
5. In your authenticator app (Google Authenticator, Authy, etc.):
   - Add the account with the displayed secret
   - Get the 6-digit code
6. Enter the 6-digit code in the form
7. Click "Verify"
8. Enter new password
9. Click "Reset Password"
10. Go back to login with new password

## Key Features Implemented

✅ **User Registration**
- Form validation
- Email uniqueness check
- Password confirmation
- Automatic login after signup

✅ **User Login**
- Email and password validation
- Remember me option
- Protected dashboard access

✅ **Forgot Password**
- Email verification
- TOTP-based verification
- Secure password reset
- No email sending required

✅ **TOTP Verification**
- Generate TOTP secrets
- Display secret for manual entry
- Verify 6-digit codes
- Time-based code validation

✅ **Session Management**
- Database sessions
- Automatic logout
- Session cleanup

## Database Setup

The application uses SQLite by default (stored in `database/database.sqlite`).

### Switch to Supabase PostgreSQL

1. Install PHP PostgreSQL driver (see SUPABASE_SETUP.md)
2. Update `.env`:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=db.idfjadtzqobtucxqkcuy.supabase.co
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=Gh#@35Z2?
   ```
3. Run migrations: `php artisan migrate`

## File Locations

| File | Purpose |
|------|---------|
| `app/Http/Controllers/Auth/SignUpController.php` | Registration logic |
| `app/Http/Controllers/Auth/LoginController.php` | Login logic |
| `app/Http/Controllers/Auth/ForgotPasswordController.php` | Password reset initiation & TOTP verification |
| `app/Http/Controllers/Auth/ResetPasswordController.php` | Password update logic |
| `app/Models/User.php` | User model with TOTP support |
| `routes/web.php` | All routes defined here |
| `resources/views/auth/` | Authentication forms |
| `resources/views/layouts/app.blade.php` | Base layout |

## Environment Configuration

Key `.env` settings:

```env
APP_NAME=Laravel
APP_URL=http://127.0.0.1:8000
APP_DEBUG=true

DB_CONNECTION=sqlite
# DB_CONNECTION=pgsql  # For Supabase

SESSION_DRIVER=database
```

## Common Commands

```bash
# Run migrations
php artisan migrate

# Fresh database (delete and recreate)
php artisan migrate:fresh

# View routes
php artisan route:list

# Tinker shell for testing
php artisan tinker

# Clear cache
php artisan cache:clear
```

## Authenticator Apps to Use

For testing TOTP:

1. **Google Authenticator** (Recommended)
   - iOS: App Store
   - Android: Play Store

2. **Microsoft Authenticator**
   - Works with Windows, iOS, Android

3. **Authy**
   - Multi-platform, cloud backup
   - Web: https://www.authy.com/

4. **FreeOTP** (Open Source)
   - iOS/Android
   - No account required

## Test User Credentials

After creating account:

```
Email: john@example.com
Password: SecurePass123
```

## Helpful URLs

| URL | Purpose |
|-----|---------|
| `/` | Home page |
| `/signup` | Registration form |
| `/login` | Login form |
| `/forgot-password` | Password reset request |
| `/verify-totp-forgot` | TOTP verification |
| `/reset-password` | Password reset form |
| `/dashboard` | User dashboard (auth required) |
| `/logout` | Logout (POST request) |

## Next Steps

1. Test all authentication flows
2. Integrate with your frontend
3. Configure email notifications (optional)
4. Set up Supabase PostgreSQL (production)
5. Deploy to production server

## Need Help?

- Check `AUTHENTICATION.md` for detailed documentation
- See `SUPABASE_SETUP.md` for PostgreSQL setup
- Review controller files for implementation details
