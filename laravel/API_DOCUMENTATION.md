# API Documentation & Usage Examples

## Overview

This document provides detailed information about the authentication system endpoints and how to use them.

## Base URL

```
http://127.0.0.1:8000
```

## Authentication Endpoints

### 1. Sign Up / Register

**Endpoint**: `POST /signup`

**Description**: Create a new user account

**Form Parameters**:
```
name: string (required, max 255 characters)
email: string (required, email format, unique)
password: string (required, minimum 8 characters)
password_confirmation: string (required, must match password)
```

**Request Example**:
```html
<form method="POST" action="/signup">
    @csrf
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <button type="submit">Sign Up</button>
</form>
```

**Success Response**:
- Status: 302 (Redirect)
- Location: `/dashboard`
- Message: "Account created successfully!"

**Error Responses**:
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email has already been taken."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

**View**: `GET /signup`

---

### 2. Login

**Endpoint**: `POST /login`

**Description**: Authenticate user and create session

**Form Parameters**:
```
email: string (required, email format)
password: string (required)
remember: boolean (optional)
```

**Request Example**:
```html
<form method="POST" action="/login">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <label>
        <input type="checkbox" name="remember"> Remember me
    </label>
    <button type="submit">Sign in</button>
</form>
```

**Success Response**:
- Status: 302 (Redirect)
- Location: `/dashboard`
- Message: "Logged in successfully!"

**Error Response**:
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The provided credentials do not match our records."]
    }
}
```

**View**: `GET /login`

---

### 3. Forgot Password - Initiate

**Endpoint**: `POST /forgot-password`

**Description**: Start password reset process by requesting email

**Form Parameters**:
```
email: string (required, must exist in database)
```

**Request Example**:
```html
<form method="POST" action="/forgot-password">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Continue</button>
</form>
```

**Success Response**:
- Status: 302 (Redirect)
- Location: `/verify-totp-forgot`
- Message: "Enter the TOTP code from your authenticator app."

**Error Response**:
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The selected email is invalid."]
    }
}
```

**Session Data Created**:
```php
session('password_reset_email') = 'user@example.com'
session('password_reset_totp_secret') = 'JBSWY3DPEBLW64TMMQ======'
```

**View**: `GET /forgot-password`

---

### 4. Verify TOTP for Password Reset

**Endpoint**: `POST /verify-totp-forgot`

**Description**: Verify TOTP code to authenticate password reset

**Form Parameters**:
```
totp_code: string (required, exactly 6 digits)
```

**Request Example**:
```html
<form method="POST" action="/verify-totp-forgot">
    @csrf
    <p>Your TOTP Secret: {{ $secret }}</p>
    <p>Scan with authenticator app or enter manually</p>
    <input type="text" name="totp_code" maxlength="6" placeholder="000000" required>
    <button type="submit">Verify</button>
</form>
```

**Success Response**:
- Status: 302 (Redirect)
- Location: `/reset-password`
- Message: "TOTP verified. Please enter your new password."

**Error Response**:
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "totp_code": ["The TOTP code is invalid."]
    }
}
```

**Session Data Updated**:
```php
session('totp_verified') = true
```

**View**: `GET /verify-totp-forgot`

---

### 5. Reset Password

**Endpoint**: `POST /reset-password`

**Description**: Update user password after TOTP verification

**Requires**:
- Session: `totp_verified = true`
- Session: `password_reset_email`

**Form Parameters**:
```
password: string (required, minimum 8 characters)
password_confirmation: string (required, must match password)
```

**Request Example**:
```html
<form method="POST" action="/reset-password">
    @csrf
    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <button type="submit">Reset Password</button>
</form>
```

**Success Response**:
- Status: 302 (Redirect)
- Location: `/login`
- Message: "Password reset successfully. Please login with your new password."

**Error Response**:
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "password": ["The password must be at least 8 characters."]
    }
}
```

**Session Data Cleared**:
```php
session()->forget([
    'password_reset_email',
    'password_reset_totp_secret',
    'totp_verified',
])
```

**View**: `GET /reset-password`

---

### 6. Logout

**Endpoint**: `POST /logout`

**Description**: Terminate user session

**Requires**: 
- User must be authenticated
- CSRF token

**Request Example**:
```html
<form method="POST" action="/logout">
    @csrf
    <button type="submit">Sign Out</button>
</form>
```

**Success Response**:
- Status: 302 (Redirect)
- Location: `/login`
- Message: "Logged out successfully!"

**Session Effects**:
- Session invalidated
- Token regenerated
- Cookies cleared

---

### 7. Dashboard

**Endpoint**: `GET /dashboard`

**Description**: User dashboard (protected route)

**Requires**: Authenticated user session

**Response**: Displays user information
```
Name: [User's Name]
Email: [User's Email]
```

**Redirect**: If not authenticated, redirects to `/login`

---

## HTTP Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Request successful |
| 302 | Redirect - Successful form submission |
| 422 | Unprocessable Entity - Validation failed |
| 404 | Not Found - Route not found |
| 500 | Server Error - Internal server error |

---

## Session Management

### Session Variables

```php
// Authentication
auth()->check()          // Check if user is authenticated
auth()->user()           // Get current user
auth()->id()            // Get current user ID

// Password Reset Flow
session('password_reset_email')       // Email of user resetting password
session('password_reset_totp_secret') // TOTP secret
session('totp_verified')              // TOTP verification status
```

### Session Configuration

```env
SESSION_DRIVER=database        # Store sessions in database
SESSION_LIFETIME=120           # Session timeout in minutes (2 hours)
SESSION_ENCRYPT=false          # Encrypt session data
```

---

## Validation Rules

### Sign Up Validation

```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|string|lowercase|email|max:255|unique:users',
    'password' => 'required|string|min:8|confirmed',
]
```

### Login Validation

```php
[
    'email' => 'required|string|lowercase|email',
    'password' => 'required|string',
]
```

### Forgot Password Validation

```php
[
    'email' => 'required|string|lowercase|email|exists:users',
]
```

### TOTP Verification Validation

```php
[
    'totp_code' => 'required|string|size:6',
]
```

### Password Reset Validation

```php
[
    'password' => 'required|string|min:8|confirmed',
]
```

---

## TOTP Implementation

### TOTP Library

Using `spomky-labs/otphp` library:

```php
use OTPHP\TOTP;

// Generate new secret
$totp = TOTP::create();
$secret = $totp->getSecret();

// Verify code
$totp = TOTP::create($secret);
$isValid = $totp->verify($code);
```

### Time Window

- Code valid for: 30 seconds
- Time tolerance: ±1 step (allows codes within 60-second window)

---

## Error Handling

### Validation Errors

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["Email format is invalid"],
        "password": ["Password must be at least 8 characters"]
    }
}
```

### Authentication Errors

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The provided credentials do not match our records."]
    }
}
```

### Session Expired

```
Status: 302 (Redirect)
Location: /forgot-password
Message: "Session expired. Please try again."
```

---

## Security Measures

1. **CSRF Protection**: All POST requests require `@csrf` token
2. **Password Hashing**: Bcrypt with configurable rounds (default: 12)
3. **SQL Injection**: Protected via Eloquent ORM
4. **XSS Protection**: Blade template escaping
5. **TOTP Verification**: Time-based codes with validation
6. **Session Security**: Database-backed sessions with encryption capable
7. **Input Validation**: All inputs validated before processing

---

## CORS & API Headers

Currently configured as a traditional web application with form submissions.

To convert to API:

1. Add API authentication middleware
2. Return JSON instead of redirects
3. Configure CORS headers
4. Add token-based authentication (JWT/Sanctum)

---

## Rate Limiting

Currently not implemented. To add:

```php
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('throttle:5,1'); // 5 attempts per minute
```

---

## Testing

### Using cURL

```bash
# Sign Up
curl -X POST http://127.0.0.1:8000/signup \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "name=John&email=john@example.com&password=SecurePass123&password_confirmation=SecurePass123"

# Login
curl -X POST http://127.0.0.1:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=john@example.com&password=SecurePass123" \
  -c cookies.txt

# Forgot Password
curl -X POST http://127.0.0.1:8000/forgot-password \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=john@example.com"
```

---

## Database Schema

### Users Table

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    totp_secret VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Sessions Table

```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL
);
```

---

## Future Enhancements

- [ ] Email notifications for password reset
- [ ] Resend TOTP code option
- [ ] Rate limiting on failed attempts
- [ ] Account lockout after failed attempts
- [ ] Backup codes for TOTP recovery
- [ ] Multiple TOTP devices per user
- [ ] Login activity logging
- [ ] IP-based security alerts
