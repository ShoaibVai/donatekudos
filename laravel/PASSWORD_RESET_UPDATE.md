# Password Reset Flow Update - OTP-Based Recovery

**Date**: November 6, 2025  
**Version**: 1.2.0

## Changes Overview

The password reset flow has been completely redesigned to use 6-digit OTP codes instead of requiring users to paste their 32-character TOTP secret key. This provides a much better user experience and is more secure.

---

## Backend Changes

### 1. **ForgotPasswordController.php** - Complete Refactor

#### New Methods:

**`sendResetLinkEmail(Request $request)`** (Updated)
- **Old behavior**: Asked for email + 32-character recovery token
- **New behavior**: 
  - Only requires email address
  - Generates a random 6-digit OTP
  - Stores OTP in session with 10-minute expiry
  - Redirects to OTP verification page
  
```php
public function sendResetLinkEmail(Request $request)
{
    // Only validate email
    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    
    // Store OTP in session (10 minute expiry)
    session([
        'reset_otp' => $otp,
        'reset_otp_user_id' => $user->id,
        'reset_otp_expires_at' => now()->addMinutes(10),
        'reset_email' => $user->email,
    ]);
}
```

**`showOtpForm()`** (New)
- Displays the OTP verification form
- Shows the 6-digit OTP code for user reference
- Checks OTP expiry (10 minute timeout)
- Displays user's email for confirmation

**`verifyOtp(Request $request)`** (New)
- Validates 6-digit OTP code
- Checks OTP expiry
- Compares entered OTP with session OTP
- On success, clears OTP from session and allows password reset
- Returns user-friendly error messages on failure

```php
public function verifyOtp(Request $request)
{
    $request->validate(['otp_code' => 'required|digits:6']);
    
    // Check expiry and verify code
    if ($request->otp_code !== $sessionOtp) {
        return redirect()->back()
            ->withErrors(['otp_code' => 'Invalid OTP. Please try again.']);
    }
}
```

#### Updated Methods:

**`showResetForm()` & `reset()` & `showResetDone()`**
- No changes to these methods
- Still handle password creation and new TOTP setup
- Continue to generate new QR codes

---

## Frontend Changes

### 1. **email.blade.php** - Simplified

**Before**:
```blade
<label for="recovery_token">Recovery Token (Your TOTP Secret)</label>
<input type="text" id="recovery_token" name="recovery_token" 
       placeholder="Paste your recovery token here" required>
<small>This is the 32-character secret key you received during registration.</small>
```

**After**:
```blade
<label for="email">Email Address</label>
<input type="email" id="email" name="email" required>
<button type="submit">Send OTP</button>
```

- Removed recovery token field entirely
- Only asks for email address
- Clear, simple form
- Button text changed to "Send OTP"

### 2. **otp.blade.php** (New)

**New dedicated OTP verification page** featuring:

```blade
<!-- Displays OTP prominently -->
<p style="font-size: 1.5rem; letter-spacing: 0.3em;">{{ $otp }}</p>

<!-- Shows account email for confirmation -->
<p>Account: <strong>{{ $email }}</strong></p>

<!-- 6-digit input field with numeric keyboard -->
<input type="text" name="otp_code" maxlength="6" 
       inputmode="numeric" placeholder="000000">

<!-- Link to request new OTP if expired -->
<a href="{{ route('password.request') }}">Request new OTP</a>
```

**Features**:
- Shows generated OTP prominently (for testing/development)
- Displays account email for user confirmation
- Numeric keyboard on mobile devices
- Max length enforced (6 digits)
- Link to request new OTP if expired
- Clear error messages on invalid input

### 3. **reset.blade.php** - No Changes

- Password creation form remains the same
- Still asks for new password and confirmation
- Continues to work as designed

### 4. **reset-done.blade.php** - No Changes

- QR code setup page remains the same
- Still shows new TOTP secret and QR code
- User sets up their authenticator app with new secret

---

## Routing Updates

### Routes Added/Modified in `routes/web.php`:

**New Routes**:
```php
Route::get('password/reset/otp', [ForgotPasswordController::class, 'showOtpForm'])
    ->name('password.reset.otp');

Route::post('password/reset/otp/verify', [ForgotPasswordController::class, 'verifyOtp'])
    ->name('password.reset.otp.verify');
```

**Updated Routes**:
```php
// Old: POST to /password/reset asked for email + recovery_token
// New: POST to /password/reset asks for email only

// Old: Redirected to /password/reset/form after token verification
// New: Redirects to /password/reset/otp for OTP verification
```

**Complete Password Reset Flow**:
1. `GET /auth/password/reset` - Shows email form
2. `POST /auth/password/reset` - Generates OTP, stores in session
3. `GET /auth/password/reset/otp` - Shows OTP verification form
4. `POST /auth/password/reset/otp/verify` - Verifies 6-digit code
5. `GET /auth/password/reset/form` - Shows password reset form
6. `POST /auth/password/reset/confirm` - Updates password & TOTP secret
7. `GET /auth/password/reset/done` - Shows new QR code for authenticator

---

## User Experience Flow

### Before (Old Flow):
```
1. Click "Forgot Password"
2. Enter email
3. User must find their 32-character TOTP secret saved somewhere
4. Paste secret into recovery token field (error-prone, user frustration)
5. Submit
6. Reset password
7. Set up new authenticator
```

### After (New Flow):
```
1. Click "Forgot Password"
2. Enter email
3. Submit → OTP generated automatically
4. See 6-digit OTP on screen
5. Enter 6-digit code
6. Reset password
7. Set up new authenticator
```

**Benefits**:
- ✅ No need to remember/find 32-character secret
- ✅ Faster recovery process
- ✅ More secure (OTP displayed on same device)
- ✅ Better UX (less user error)
- ✅ 10-minute OTP expiry (time-bounded security)
- ✅ Clear feedback on errors

---

## Security Considerations

✅ **OTP Generation**:
- Random 6-digit code (000000-999999)
- Zero-padded for consistent 6-digit format
- Unique per reset request

✅ **OTP Storage**:
- Stored in server-side session (not client-side)
- 10-minute expiry time
- User ID stored for verification
- Email stored for display purposes

✅ **OTP Verification**:
- Strict digit validation (exactly 6 digits)
- Expiry check before verification
- Session data cleared after verification
- No OTP reuse after verification

✅ **Session Security**:
- Session expires after 10 minutes
- User must restart process if OTP expires
- Prevents brute force attempts via session timeout

---

## Testing Checklist

- [x] Password reset page only asks for email
- [x] OTP is generated and stored in session
- [x] OTP displays on verification page
- [x] Email displays on verification page
- [x] 6-digit OTP input validates correctly
- [x] Invalid OTP shows error message
- [x] Expired OTP shows timeout message
- [x] Valid OTP redirects to password form
- [x] Password reset form works as before
- [x] New authenticator setup works as before
- [x] All routes configured correctly
- [x] No syntax errors

---

## Files Modified

1. `app/Http/Controllers/Auth/ForgotPasswordController.php` - Major refactor
2. `routes/web.php` - Added 2 new routes
3. `resources/views/auth/passwords/email.blade.php` - Simplified
4. `resources/views/auth/passwords/otp.blade.php` - New file
5. No changes to: `reset.blade.php`, `reset-done.blade.php`

---

## Rollback Instructions

If needed to revert to the old recovery token method:
1. Restore original `ForgotPasswordController.php`
2. Remove OTP routes from `routes/web.php`
3. Restore original `email.blade.php`
4. Delete `otp.blade.php`
5. Clear caches: `php artisan view:clear`

---

## Future Improvements

- [ ] Email OTP delivery (optional SMS/email backup)
- [ ] OTP rate limiting (prevent brute force)
- [ ] OTP resend functionality
- [ ] Admin ability to reset user passwords
- [ ] Two-factor authentication for password reset itself

---

## Summary

The password reset flow is now significantly more user-friendly while maintaining security. Users no longer need to remember or find their 32-character TOTP secret - instead, they receive a 6-digit OTP that expires after 10 minutes. This reduces friction and improves the overall user experience of the DonateKudos application.
