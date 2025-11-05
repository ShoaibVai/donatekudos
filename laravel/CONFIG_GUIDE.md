# Configuration Guide for Laravel Supabase Profile Manager

## Environment Variables (.env)

### Application Settings
```
APP_NAME="Donate Kudos"
APP_ENV=local  # local, staging, production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false  # Set to false in production
APP_URL=http://localhost:8000

# Admin settings
ADMIN_PASSWORD=Rishbish$$  # Change this in production!
```

### Database Configuration
```
DB_CONNECTION=pgsql
DB_HOST=your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=YOUR_PASSWORD
```

### Supabase Configuration
```
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_KEY=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...  # Anon key
SUPABASE_SERVICE_ROLE_KEY=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

### Stripe Configuration (optional)
```
SUPABASE_STRIPE_PUBLISHABLE_KEY=pk_test_...
SUPABASE_STRIPE_SECRET_KEY=sk_test_...
```

### Session & Cache
```
SESSION_DRIVER=database  # Options: file, cookie, database, redis
CACHE_DRIVER=file        # Options: file, redis, memcached, database
CACHE_PREFIX=donatekudos
```

### Mail Configuration
```
MAIL_MAILER=log  # Options: smtp, sendmail, mailgun, ses, log
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS="hello@donatekudos.com"
MAIL_FROM_NAME="Donate Kudos"
```

### Logging
```
LOG_CHANNEL=stack
LOG_LEVEL=debug  # debug, info, notice, warning, error, critical, alert, emergency
```

## Production Checklist

### Security
- [ ] Change `APP_DEBUG` to `false`
- [ ] Generate new `APP_KEY`
- [ ] Update `ADMIN_PASSWORD` from default
- [ ] Enable HTTPS/SSL
- [ ] Configure CORS for specific domains
- [ ] Set up rate limiting
- [ ] Enable CSRF protection (enabled by default)
- [ ] Configure secure session cookies
- [ ] Set up firewall rules

### Database
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Backup production database
- [ ] Enable PostgreSQL backups in Supabase
- [ ] Set up connection pooling if needed
- [ ] Configure query logging for monitoring
- [ ] Verify foreign key constraints

### Caching & Performance
- [ ] Configure Redis for production caching
- [ ] Run cache:clear before deployment
- [ ] Enable route caching: `php artisan route:cache`
- [ ] Enable config caching: `php artisan config:cache`
- [ ] Enable view caching: `php artisan view:cache`
- [ ] Set up CDN for static assets

### Monitoring & Logging
- [ ] Set up error tracking (Sentry, Rollbar, etc.)
- [ ] Configure centralized logging (ELK Stack, Datadog, etc.)
- [ ] Set up uptime monitoring
- [ ] Configure database query logging
- [ ] Set up alerts for critical errors
- [ ] Enable audit logging for admin actions

### File Storage
- [ ] Verify Supabase Storage buckets exist
- [ ] Set up proper bucket permissions (public/private)
- [ ] Configure CORS for image serving
- [ ] Test file upload and download
- [ ] Set up automatic cleanup for old files

### Deployment
- [ ] Test all routes before deploying
- [ ] Create database backup before migration
- [ ] Use deployment script: `./deploy.sh production`
- [ ] Verify migrations ran successfully
- [ ] Test critical user flows
- [ ] Monitor logs for errors
- [ ] Have rollback plan ready

## Configuration Files

### config/app.php
```php
'admin_password' => env('ADMIN_PASSWORD', 'Rishbish$$'),
'admin_email' => env('ADMIN_EMAIL', 'admin@donatekudos.com'),
```

### config/filesystems.php
```php
'disks' => [
    'supabase' => [
        'driver' => 'supabase',
        'key' => env('SUPABASE_KEY'),
        'secret' => env('SUPABASE_SERVICE_ROLE_KEY'),
        'bucket' => 'profile-galleries',  // or 'qr-codes'
    ],
],
```

## Nginx Configuration Example

```nginx
server {
    listen 443 ssl http2;
    server_name donatekudos.com www.donatekudos.com;

    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;

    root /var/www/laravel/public;
    index index.php;

    # Security headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass php-fpm:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # Cache static assets
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    # Deny access to sensitive files
    location ~ /\. {
        deny all;
    }
}
```

## Docker Configuration Example

```dockerfile
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    postgresql-client \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/laravel
WORKDIR /var/www/laravel

RUN composer install --no-dev --optimize-autoloader

EXPOSE 9000
CMD ["php-fpm"]
```

## GitHub Actions CI/CD Example

```yaml
name: Deploy

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v2

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'

    - name: Install dependencies
      run: |
        composer install --no-dev --optimize-autoloader
        npm install --omit=dev

    - name: Build assets
      run: npm run build

    - name: Run tests
      run: php artisan test

    - name: Deploy to production
      run: bash deploy.sh production
      env:
        DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
```

## Backup Strategy

### Database Backups
- Enable automatic backups in Supabase console
- Retention: 7 days minimum
- Test restore procedure regularly

### File Backups
- Backup Supabase Storage buckets weekly
- Store backups in separate cloud storage
- Document backup/restore procedures

### Code Backups
- Use git with remotes (GitHub, GitLab, etc.)
- Tag releases in git
- Keep production and staging branches

## Security Hardening

### HTTPS/SSL
- Use Let's Encrypt for free SSL certificates
- Enable HSTS (HTTP Strict Transport Security)
- Redirect HTTP to HTTPS

### Rate Limiting
```php
// In middleware or routes
Route::middleware('throttle:60,1')->post('/login', [AuthController::class, 'login']);
```

### CORS Configuration
```php
// config/cors.php
'allowed_origins' => [
    'https://donatekudos.com',
    'https://www.donatekudos.com',
],
```

### Database Security
- Use strong passwords (25+ characters)
- Limit database user permissions
- Use SSL connections to database
- Enable row-level security in Supabase

## Monitoring Dashboard

### Key Metrics
- Active users
- API response times
- Database query performance
- Error rates
- File storage usage
- CPU and memory usage

### Alerting
- Alert on error rate > 1%
- Alert on response time > 1s
- Alert on disk usage > 80%
- Alert on failed deployments
