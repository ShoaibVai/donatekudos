#!/bin/bash

# Deploy script for Laravel Supabase Profile Manager
# This script handles deployment steps for production environments

set -e

echo "=== Laravel Supabase Profile Manager Deployment ==="
echo ""

# Check if environment is provided
if [ -z "$1" ]; then
    echo "Usage: ./deploy.sh [production|staging]"
    exit 1
fi

ENV=$1

echo "Deploying to: $ENV"
echo ""

# Step 1: Install dependencies
echo "Step 1: Installing dependencies..."
composer install --no-dev --optimize-autoloader
npm install --omit=dev
npm run build

# Step 2: Clear caches
echo "Step 2: Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Step 3: Rebuild caches
echo "Step 3: Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 4: Run migrations
echo "Step 4: Running database migrations..."
php artisan migrate --force

# Step 5: Seed database (optional)
# echo "Step 5: Seeding database..."
# php artisan db:seed --force

echo ""
echo "=== Deployment Complete ==="
echo "Application is ready for use!"
