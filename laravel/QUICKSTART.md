# Quick Start Guide - Laravel Supabase Profile Manager

## 5-Minute Setup

### 1. Prerequisites Installed?
- ✅ PHP 8.1+
- ✅ Composer
- ✅ Node.js & npm
- ✅ Supabase Account

### 2. Clone & Install (2 min)
```bash
cd laravel
composer install
npm install
```

### 3. Environment Setup (1 min)
```bash
cp .env.example .env
php artisan key:generate
```

**Add to `.env`:**
```
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_KEY=your-anon-key
SUPABASE_SERVICE_ROLE_KEY=your-service-role-key
```

### 4. Database Setup (1 min)
```bash
php artisan migrate
```

### 5. Start Server (1 min)
```bash
php artisan serve
npm run dev  # in another terminal
```

Visit: `http://localhost:8000`

---

## Common Tasks

### Run Tests
```bash
php artisan test
```

### Reset Database
```bash
php artisan migrate:refresh
```

### Create Admin
Login at `/admin` with password: `Rishbish$$`

### Build for Production
```bash
npm run build
php artisan config:cache
php artisan route:cache
```

---

## Project Structure

```
laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/           # All controllers
│   │   └── Middleware/
│   └── Models/                    # Eloquent models
├── database/
│   ├── migrations/                # All migrations
│   └── seeders/
├── routes/                        # API and web routes
├── resources/
│   ├── views/                     # Blade templates
│   ├── css/
│   └── js/
└── tests/
    ├── Unit/                      # Unit tests
    └── Feature/                   # Feature tests
```

---

## Key Files

| File | Purpose |
|------|---------|
| `routes/web.php` | Web routes & endpoints |
| `app/Models/Profile.php` | Profile model |
| `app/Http/Controllers/ProfileController.php` | Profile logic |
| `.env` | Configuration & credentials |
| `PROJECT_SETUP.md` | Full documentation |
| `CONFIG_GUIDE.md` | Production setup |

---

## Features Overview

### 👤 User Profiles
- Create & edit profiles
- Store contact info & wallet addresses
- Public profile pages
- JSON data storage

### 🖼️ Gallery System
- Upload images to Supabase Storage
- Organize by profile
- Delete and manage

### 🔐 2FA/TOTP
- Enable/disable 2FA
- TOTP secret generation
- Backup recovery tokens

### 👨‍💼 Admin Panel
- View all users
- Manage profiles
- Export data as XML

### 🗑️ Data Archival
- Delete profiles with archival
- 30-day retention
- Snapshot preservation

---

## API Endpoints

### Public
- `GET /` - Home
- `GET /profile/{username}` - View profile
- `GET /api/profile/{username}` - API endpoint

### Authenticated
- `GET /dashboard` - Dashboard
- `GET /profile/edit` - Edit form
- `POST /profile/update` - Save changes
- `GET /profile/gallery` - Gallery
- `POST /gallery/upload` - Upload image

### Admin
- `GET /admin` - Login
- `GET /admin/dashboard` - Dashboard
- `GET /admin/users` - User list
- `GET /admin/export/xml` - Export

---

## Database Tables

### profiles
- id (UUID)
- user_id (UUID)
- username (String)
- bio (Text)
- contact_info (JSONB)
- wallet_addresses (JSONB)

### galleries
- id (UUID)
- profile_id (UUID)
- image_url (String)
- filename (String)

### archived_profiles
- id (UUID)
- original_profile_id (UUID)
- user_data (JSONB)
- gallery_data (JSONB)

### recovery_tokens
- id (UUID)
- user_id (UUID)
- token (String)
- is_enabled (Boolean)

---

## Troubleshooting

### Migrations Fail
```bash
# Check Supabase connection
php artisan tinker
>>> DB::connection()->getPdo()
```

### Can't Upload Files
- Verify Supabase Storage bucket exists
- Check bucket permissions
- Verify SUPABASE_KEY has access

### Routes Not Found
```bash
php artisan route:list        # List all routes
php artisan route:cache       # Cache routes
```

### Tests Failing
```bash
php artisan test --verbose    # See detailed output
php artisan test tests/Unit/ProfileCreationTest  # Run single test
```

---

## Next Steps

1. **Customize**: Edit views in `resources/views/`
2. **Deploy**: Follow `CONFIG_GUIDE.md` for production
3. **Scale**: Add caching with Redis
4. **Monitor**: Set up error tracking (Sentry)
5. **Secure**: Update ADMIN_PASSWORD in `.env`

---

## Documentation

- 📘 **Full Setup**: `PROJECT_SETUP.md`
- ⚙️ **Configuration**: `CONFIG_GUIDE.md`
- 📝 **Laravel Docs**: https://laravel.com/docs
- 🚀 **Supabase Docs**: https://supabase.com/docs

---

## Support

**Need help?**
- Check the full documentation in `PROJECT_SETUP.md`
- Review error logs: `storage/logs/`
- Check database connection
- Verify Supabase credentials

---

**Ready to build? Start with: `php artisan serve`** 🚀
