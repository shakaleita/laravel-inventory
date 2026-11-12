# Laravel Inventory

A practical inventory management MVP built with Laravel 11, Blade, Bootstrap, and MySQL.

## Features

- Product and category management
- Stock quantity and reorder-level tracking
- Low-stock dashboard alerts
- Product search and filtering
- Form validation and CSRF protection
- Database migrations and seed data

## Requirements

- PHP 8.2+
- Composer
- MySQL 8+
- Node.js 20+ (optional for frontend assets)

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Open `http://127.0.0.1:8000`.

## Database

Set `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env` before running migrations.

## Testing

```bash
php artisan test
```

## Roadmap

Stock movement records, supplier management, CSV export, authentication, and role-based access can be added as the next iteration.
