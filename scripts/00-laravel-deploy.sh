#!/usr/bin/env bash
set -e

echo "Clearing old cached config..."
php artisan config:clear || true

echo "Running migrations..."
php artisan migrate --force

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache
