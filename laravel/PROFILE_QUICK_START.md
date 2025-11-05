# Quick Start - Profile System Testing Guide

## Server Setup

The Laravel development server is running at: **http://127.0.0.1:8000**

```bash
# To restart the server:
cd d:\Documents\Projects\donatekudos\laravel
php artisan serve --host=127.0.0.1 --port=8000
```

---

## Testing Flow

### 1. Create Account & Setup TOTP
1. Go to http://127.0.0.1:8000/signup
2. Enter name and email
3. Create a password
4. Scan TOTP QR code with authenticator app
5. Enter TOTP code to verify

### 2. Login
1. Go to http://127.0.0.1:8000/login
2. Enter email and password
3. You're now logged in

### 3. Create Profile
1. Go to http://127.0.0.1:8000/profile or click "Create Profile"
2. Fill in optional profile fields:
   - Phone number
   - Bio
   - Bitcoin address: `1A1z7agoat8h9ju76rvn5fghaj4ch2wy3` (example)
   - Ethereum address: `0x742d35Cc6634C0532925a3b844Bc9e7595f7` (example)
   - Other addresses (JSON): `{"litecoin": "LdT4ubS5NySFHvMad8f", "ripple": "rN7n7otQDd6FczFgLdlqXD"}`
   - Social media (JSON): `{"twitter": "https://twitter.com/user", "github": "https://github.com/user"}`
3. Click "Create Profile"
4. You'll get a unique profile URL (e.g., `@your-name` or `@your-name-1`)

### 4. Upload Gallery
1. On your profile page, scroll to "Gallery" section
2. Select an image file (JPEG, PNG, GIF, or WebP; max 5MB)
3. Add description and category (optional)
4. Click "Upload Image"
5. Image appears in gallery grid
6. Try uploading multiple images (12 per page)

### 5. Upload Wallet QR Codes
1. On your profile page, scroll to "Wallet QR Codes" section
2. Enter cryptocurrency type (e.g., "Bitcoin", "Ethereum")
3. Select QR code image (JPEG, PNG, GIF; max 2MB)
4. Click "Upload Wallet QR Code"
5. QR code appears in wallet section

### 6. Edit Profile
1. Click "Edit Profile" button
2. Modify any information
3. Update social media or other addresses as JSON
4. Click "Save Changes"

### 7. Test Public Profile
1. Copy your profile URL from your profile page
2. Open in new browser tab or incognito (to test guest view)
3. Public profile shows all your info without edit/delete buttons
4. Gallery displays with pagination

### 8. Delete Profile
1. On your profile page, click "Delete Profile" button
2. Confirm deletion
3. Your profile is deleted, data archived, you're logged out

---

## Admin Panel Testing

### Access Admin Panel
1. Go to http://127.0.0.1:8000/admin/login
2. Enter password: `Rishbish$$`
3. Click "Access Admin Panel"

### Dashboard Features
1. **View Users**: See all users with pagination
2. **Search Users**: Search by name or email
3. **Delete User**: Click Delete next to user to remove account
4. **Export Data**: Click "Download all users as XML" button

### Deleted Users
1. Click "Deleted Users (X)" tab
2. View archived deleted user data
3. Click "View Details" to see full user data as JSON

### Logout
1. Click "Logout" button in top right
2. Session ends, you're redirected to home

---

## Test Data URLs

| Feature | URL |
|---------|-----|
| Home | http://127.0.0.1:8000 |
| Signup | http://127.0.0.1:8000/signup |
| Login | http://127.0.0.1:8000/login |
| Dashboard | http://127.0.0.1:8000/dashboard |
| My Profile | http://127.0.0.1:8000/profile |
| Create Profile | http://127.0.0.1:8000/profile/create |
| Edit Profile | http://127.0.0.1:8000/profile/edit |
| Public Profile | http://127.0.0.1:8000/@your-profile-url |
| Admin Login | http://127.0.0.1:8000/admin/login |
| Admin Dashboard | http://127.0.0.1:8000/admin |
| Deleted Users | http://127.0.0.1:8000/admin/deleted-users |

---

## Common Test Cases

### Gallery Testing
```
✓ Upload image < 5MB
✓ Try uploading image > 5MB (should fail)
✓ Upload WebP, PNG, GIF, JPEG formats
✓ Add description and category
✓ Delete image from gallery
✓ Test pagination (add 15+ images)
```

### Wallet QR Testing
```
✓ Upload QR code < 2MB
✓ Try uploading QR code > 2MB (should fail)
✓ Add multiple cryptocurrencies
✓ Delete QR code
```

### Profile Sharing
```
✓ Copy profile URL
✓ Open in incognito/new browser
✓ Verify no edit/delete buttons
✓ Gallery displays correctly
✓ Social links are clickable
```

### Admin Functions
```
✓ Login with correct password
✓ Try login with wrong password
✓ Search for specific user
✓ Delete user account
✓ User appears in deleted users
✓ Export to XML
✓ View deleted user details
```

---

## JSON Format Examples

### Other Addresses JSON
```json
{
  "litecoin": "LdT4ubS5NySFHvMad8f",
  "ripple": "rN7n7otQDd6FczFgLdlqXD",
  "dogecoin": "DMwfn3YsFEe8yuCc26f5",
  "cardano": "addr1q88qg3z69r5zj2zf6v7"
}
```

### Social Media JSON
```json
{
  "twitter": "https://twitter.com/username",
  "github": "https://github.com/username",
  "linkedin": "https://linkedin.com/in/username",
  "instagram": "https://instagram.com/username",
  "website": "https://mywebsite.com"
}
```

---

## Validation Rules

### Profile Fields
- **Phone**: Optional, max 20 characters
- **Bio**: Optional, max 1000 characters
- **Addresses**: Optional, max 255 characters each
- **Other Addresses**: Valid JSON format required
- **Social Media**: Valid JSON format required

### File Uploads
- **Gallery Images**: Max 5MB, formats: JPEG, PNG, GIF, WebP
- **Wallet QR Codes**: Max 2MB, formats: JPEG, PNG, GIF
- **Description**: Optional, max 500 characters
- **Category**: Optional, max 100 characters
- **Cryptocurrency Type**: Required, max 50 characters

---

## Database Tables

All tables created and populated in SQLite:

1. ✅ `users` - User accounts with TOTP support
2. ✅ `profiles` - User profiles with contact/address info
3. ✅ `wallet_qr_codes` - Cryptocurrency wallet QR codes
4. ✅ `gallery_items` - User gallery images
5. ✅ `deleted_users` - Archive of deleted user data

View tables:
```bash
cd d:\Documents\Projects\donatekudos\laravel
php artisan tinker

# List all profiles
>>> App\Models\Profile::with('user', 'galleryItems', 'walletQrCodes')->get();

# List all deleted users
>>> App\Models\DeletedUser::all();
```

---

## File Structure (New Files)

```
Created:
✓ app/Http/Controllers/ProfileController.php
✓ app/Http/Controllers/AdminController.php
✓ app/Models/Profile.php
✓ app/Models/WalletQrCode.php
✓ app/Models/GalleryItem.php
✓ app/Models/DeletedUser.php
✓ resources/views/profile/create.blade.php
✓ resources/views/profile/edit.blade.php
✓ resources/views/profile/show.blade.php
✓ resources/views/profile/public.blade.php
✓ resources/views/admin/login.blade.php
✓ resources/views/admin/dashboard.blade.php
✓ resources/views/admin/deleted-users.blade.php
✓ database/migrations/2025_11_05_000004_create_profile_tables.php

Updated:
✓ app/Models/User.php (added profile() relationship)
✓ routes/web.php (added profile and admin routes)
```

---

## File Upload Storage

Uploaded files stored in:
- **Gallery images**: `storage/app/public/gallery/`
- **Wallet QR codes**: `storage/app/public/wallets/`

Access via web:
- Gallery: http://127.0.0.1:8000/storage/gallery/filename
- Wallet: http://127.0.0.1:8000/storage/wallets/filename

**Note**: Requires `php artisan storage:link` to create public symlink

---

## Troubleshooting

### Images not showing?
```bash
php artisan storage:link
```

### Routes not working?
```bash
php artisan route:clear
php artisan route:cache
```

### Database issues?
```bash
php artisan migrate:fresh
php artisan migrate
```

### Get Laravel Tinker shell:
```bash
php artisan tinker
```

---

## API Endpoints Summary

| Method | Route | Auth | Purpose |
|--------|-------|------|---------|
| GET | /profile | Yes | View my profile |
| GET | /profile/create | Yes | Create profile form |
| POST | /profile | Yes | Store new profile |
| GET | /profile/edit | Yes | Edit profile form |
| POST | /profile/update | Yes | Update profile |
| POST | /profile/gallery | Yes | Upload image |
| DELETE | /profile/gallery/{id} | Yes | Delete image |
| POST | /profile/wallet | Yes | Upload QR code |
| DELETE | /profile/wallet/{id} | Yes | Delete QR code |
| DELETE | /profile | Yes | Delete profile |
| GET | /@{url} | No | View public profile |
| GET | /admin/login | No | Admin login |
| POST | /admin/login | No | Verify password |
| GET | /admin | No* | Admin dashboard |
| GET | /admin/deleted-users | No* | Deleted users |
| GET | /admin/export-xml | No* | Export as XML |
| DELETE | /admin/users/{id} | No* | Delete user |
| POST | /admin/logout | No* | Logout admin |

*No session-based auth required (custom admin session check)

---

## Next Steps

1. ✅ Complete profile creation and editing
2. ✅ Test gallery image uploads
3. ✅ Test wallet QR code uploads
4. ✅ Share public profiles
5. ✅ Test admin panel
6. ✅ Export user data as XML
7. 📋 Run unit/feature tests (optional)
8. 📋 Deploy to production

---

**Status**: ✅ Profile system fully implemented and ready for testing
**Last Updated**: November 5, 2025
