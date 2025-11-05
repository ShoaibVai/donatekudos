# 🎉 Laravel Supabase Profile Manager

> A complete, production-ready Laravel 10.x application for managing user profiles with TOTP authentication, gallery system, and admin panel. Fully integrated with Supabase.

## ✨ Features

✅ **User Profiles** - Create, edit, and delete profiles with JSONB data storage  
✅ **Image Gallery** - Upload and manage images via Supabase Storage  
✅ **2FA/TOTP** - Two-factor authentication with TOTP secrets  
✅ **Admin Panel** - User management, statistics, and XML export  
✅ **Public Profiles** - Shareable profile pages and JSON API  
✅ **Data Archival** - 30-day retention on profile deletion  
✅ **Security** - CSRF, XSS, SQL injection protection  
✅ **Tests** - Comprehensive unit tests included  

## 🚀 Quick Start

```bash
# Install dependencies
composer install && npm install

# Setup environment
php artisan key:generate

# Run migrations
php artisan migrate

# Start development
php artisan serve
```

Visit: `http://localhost:8000`

**Admin**: `/admin` | Password: `Rishbish$$`

## 📚 Documentation

| Document | Purpose |
|----------|---------|
| **[QUICKSTART.md](./QUICKSTART.md)** | 5-minute setup guide |
| **[PROJECT_SETUP.md](./PROJECT_SETUP.md)** | Complete installation & features |
| **[CONFIG_GUIDE.md](./CONFIG_GUIDE.md)** | Production configuration & deployment |
| **[IMPLEMENTATION_CHECKLIST.md](./IMPLEMENTATION_CHECKLIST.md)** | Status & roadmap |
| **[PROJECT_SUMMARY.md](./PROJECT_SUMMARY.md)** | Project overview |
| **[DELIVERY_SUMMARY.md](./DELIVERY_SUMMARY.md)** | What was delivered |

## 🏗️ Architecture

### Models (4)
- `Profile` - User profiles with contact info & wallet addresses
- `Gallery` - Image storage with cascade delete
- `ArchivedProfile` - Profile snapshots (30-day retention)
- `RecoveryToken` - TOTP secret management

### Controllers (8)
- `ProfileController` - Profile CRUD
- `GalleryController` - Image management
- `TwoFactorController` - 2FA setup
- `Admin/*` - Admin operations
- `Api\ProfileController` - JSON API

### Routes (20+)
- Public: home, profile display, API
- Auth: dashboard, profile management, gallery, 2FA
- Admin: login, dashboard, users, export

### Views (11)
- Layouts, profiles, gallery, admin, home

## 🗄️ Database Schema

```
profiles (UUID, user_id, username, contact_info JSONB, wallet_addresses JSONB)
galleries (UUID, profile_id, image_url, filename)
archived_profiles (UUID, original_profile_id, user_data JSONB, deleted_at)
recovery_tokens (UUID, user_id, token, is_enabled, is_verified)
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Unit/ProfileCreationTest
```

Tests included:
- Profile creation & validation
- Gallery relationships
- Profile archival
- TOTP token management

## 🔐 Security

✅ CSRF protection  
✅ XSS prevention  
✅ SQL injection protection (Eloquent)  
✅ Password hashing (bcrypt)  
✅ Secure session handling  
✅ TOTP secrets hidden  
✅ Cascade deletion  
✅ Foreign key constraints  

## 📊 Project Stats

| Metric | Count |
|--------|-------|
| Models | 4 |
| Controllers | 8 |
| Routes | 20+ |
| Views | 11 |
| Migrations | 4 |
| Tests | 4 classes, 15+ tests |
| Documentation Pages | 6 |
| Lines of Code | 3,000+ |

## 🛠️ Tech Stack

- **Backend**: Laravel 10.x
- **Database**: PostgreSQL (Supabase)
- **Auth**: Supabase Authentication
- **Storage**: Supabase Storage
- **Frontend**: Blade + Tailwind CSS
- **Testing**: PHPUnit

## 📋 API Endpoints

### Public
```
GET /                           # Home
GET /profile/{username}         # Profile page
GET /api/profile/{username}     # JSON API
```

### Authenticated
```
GET /dashboard                  # Dashboard
GET /profile/edit               # Edit form
POST /profile/update            # Save
GET /profile/gallery            # Gallery
POST /gallery/upload            # Upload
DELETE /gallery/{id}            # Delete
POST /2fa/enable                # Enable 2FA
```

### Admin
```
GET /admin                      # Login
GET /admin/dashboard            # Dashboard
GET /admin/users                # Users
GET /admin/export/xml           # Export
```

## 🚀 Deployment

See **[CONFIG_GUIDE.md](./CONFIG_GUIDE.md)** for production setup.

```bash
# Pre-deployment
composer install --no-dev
npm run build

# Deployment
php artisan migrate --force
./deploy.sh production
```

## 📁 File Structure

```
laravel/
├── app/Models/                 # 4 Eloquent models
├── app/Http/Controllers/       # 8 Controllers
├── database/migrations/        # 4 Migrations
├── routes/                     # Web & API routes
├── resources/views/            # 11 Blade views
├── tests/Unit/                 # Unit tests
└── [Documentation]             # 6 guides
```

## ⚙️ Configuration

Update `.env` with Supabase credentials:
```
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_KEY=your-anon-key
SUPABASE_SERVICE_ROLE_KEY=your-service-role-key
```

## 📞 Support

**Getting started?** → `QUICKSTART.md`  
**Installation help?** → `PROJECT_SETUP.md`  
**Deploying?** → `CONFIG_GUIDE.md`  
**Roadmap?** → `IMPLEMENTATION_CHECKLIST.md`  

## ✅ Status

**Version**: 1.0.0 (MVP)  
**Status**: ✅ Complete & Production-Ready  
**Last Updated**: November 6, 2025  

---

Made with ❤️ using Laravel & Supabase
