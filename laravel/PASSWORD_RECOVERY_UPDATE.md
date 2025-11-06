# Password Recovery Flow Update

**Date**: November 6, 2025  
**Version**: 1.1.1

## Change Summary

Updated the password recovery/forgot password flow to use **6-digit TOTP codes** instead of the 32-character secret key for verification.

## Why This Change?

1. **Better User Experience**: Users don't need to store/copy the secret key - they just enter the 6-digit code from their authenticator app
2. **More Secure**: TOTP codes are time-limited and change every 30 seconds
3. **Consistent**: Matches the 2FA verification flow during login
4. **Less Error-Prone**: Numeric input only, no risk of copying special characters

## What Changed

### Backend (Controller)

**File**: `app/Http/Controllers/Auth/ForgotPasswordController.php`

**Method**: `sendResetLinkEmail(Request $request)`

**Before**:
- Requested: 32-character `recovery_token` (the TOTP secret)
- Validation: Direct string comparison with stored secret
- Comparison method: `$user->totp_secret !== trim($request->recovery_token)`

**After**:
- Requests: 6-digit `totp_code` (authenticator app code)
- Validation: TOTP verification using Google2FA library
- Verification method: `$this->google2fa->verifyKey($user->totp_secret, $request->totp_code)`

**Code Changes**:
```php
// BEFORE
$request->validate([
    'email' => 'required|email|exists:users,email',
    'recovery_token' => 'required',
]);

// Verify recovery token (TOTP secret) - trim whitespace and compare
$providedToken = trim($request->recovery_token);
if ($user->totp_secret !== $providedToken) {
    // Error
}

// AFTER
$request->validate([
    'email' => 'required|email|exists:users,email',
    'totp_code' => 'required|digits:6',
]);

// Verify TOTP code using the user's current secret
if (!$this->google2fa->verifyKey($user->totp_secret, $request->totp_code)) {
    // Error
}
```

### Frontend (Form)

**File**: `resources/views/auth/passwords/email.blade.php`

**Form Label Change**:
- From: "Recovery Token (Your TOTP Secret)"
- To: "6-Digit Authenticator Code"

**Input Field Changes**:
```blade
<!-- BEFORE -->
<input type="text" id="recovery_token" name="recovery_token" 
       placeholder="Paste your recovery token here" required>
<small>This is the 32-character secret key you received during registration.</small>

<!-- AFTER -->
<input type="text" id="totp_code" name="totp_code" 
       placeholder="000000" maxlength="6" inputmode="numeric" 
       pattern="[0-9]{6}" required>
<small>Enter the 6-digit code from Google Authenticator, Authy, or your authenticator app.</small>
```

**Button Text Change**:
- From: "Next Step"
- To: "Verify & Reset Password"

**Page Title Change**:
- From: "Reset Password"
- To: "Forgot Password?"

## Flow Diagram

```
User forgets password
    ↓
Visit: /auth/password/reset
    ↓
Enter email + 6-digit TOTP code
    ↓
Backend validates TOTP code against user's stored secret
    ↓
If valid: Show password reset form
If invalid: Show error, ask user to try again
    ↓
User enters new password
    ↓
System generates new TOTP secret
    ↓
System shows QR code for new authenticator setup
    ↓
Done!
```

## User Experience Flow

### Old Flow
1. User enters email
2. User pastes 32-character secret key from saved location
3. Backend checks if secret matches exactly
4. User sets new password
5. User scans new QR code with authenticator app

### New Flow
1. User enters email
2. User opens authenticator app
3. User enters 6-digit code from authenticator app
4. Backend validates code in real-time
5. User sets new password
6. User scans new QR code with authenticator app

## Security Improvements

### TOTP Verification Benefits
1. **Time-Limited**: TOTP codes expire after 30 seconds (configurable in Google2FA)
2. **Dynamic**: Codes change every 30 seconds - can't reuse old codes
3. **No Storage Vulnerability**: Doesn't require users to store plain text secret
4. **Industry Standard**: Same method used by Google, Microsoft, GitHub, etc.

### Comparison

| Aspect | Old Method | New Method |
|--------|-----------|-----------|
| Secret storage | User must save/store | No storage needed |
| Verification | String comparison | TOTP algorithm |
| Attack vector | Lost/stolen secret | None (time-limited) |
| Usability | Find and paste secret | Open app and enter code |
| Error messages | Generic | Specific to TOTP |

## Error Handling

### New Error Messages

**Invalid Email**:
- "No account found with this email."

**Invalid TOTP Code**:
- "Invalid TOTP code. Please check your authenticator app and try again."

**Session Expired**:
- "Session expired. Please try again."

## Testing

### Test Case 1: Valid TOTP Code
1. Go to `/auth/password/reset`
2. Enter registered email
3. Enter current 6-digit code from authenticator app
4. ✅ Should be redirected to password reset form

### Test Case 2: Invalid TOTP Code
1. Go to `/auth/password/reset`
2. Enter registered email
3. Enter wrong 6-digit code
4. ✅ Should see error message and remain on same page

### Test Case 3: Non-existent Email
1. Go to `/auth/password/reset`
2. Enter non-existent email
3. Enter any code
4. ✅ Should see email not found error

## Backward Compatibility

⚠️ **Breaking Change**: Users who saved their 32-character secret key as a recovery method will no longer be able to use it.

**Migration Path**:
1. Users who lost access to their authenticator app should contact support
2. Admins can manually reset their authenticator secret
3. Users can re-register with their authenticator app

## Files Modified

1. `app/Http/Controllers/Auth/ForgotPasswordController.php`
   - Method: `sendResetLinkEmail()`
   - Change: TOTP validation instead of secret key comparison

2. `resources/views/auth/passwords/email.blade.php`
   - Updated form field from `recovery_token` to `totp_code`
   - Updated labels and help text
   - Updated input type to `numeric` with 6-digit limit

## Deployment Notes

1. Clear view cache: `php artisan view:clear`
2. No database migrations needed
3. No config changes needed
4. Users can immediately use new password recovery method

## Future Enhancements

1. Rate limiting on TOTP attempts (prevent brute force)
2. Show masked email for account verification
3. SMS/Email verification as alternative recovery method
4. Recovery codes as backup for lost authenticator apps
5. Support request flow for account recovery

---

## Rollback Plan (if needed)

To revert to old method:
1. Revert `ForgotPasswordController.php` from git
2. Revert `resources/views/auth/passwords/email.blade.php` from git
3. Clear cache: `php artisan view:clear`

Command:
```bash
git checkout app/Http/Controllers/Auth/ForgotPasswordController.php
git checkout resources/views/auth/passwords/email.blade.php
php artisan view:clear
```
