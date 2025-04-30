# SBCMS Project

A RESTful API for a subscription-based content platform that allows users to access articles based on their subscription plan. The system handles authentication, access control, caching, and performance optimization.

## Prerequisites

-   PHP 8.1+
-   Composer
-   Node.js 16+
-   MySQL/SQLite

## Installation

```bash
git clone https://github.com/themaruf/sbcms.git
cd sbcms
composer install
cp .env.example .env
```

## Configuration

1. Create database (`sbcms` for MySQL or `database/database.sqlite` for SQLite)
2. Update `.env` with your database credentials
3. Generate application key:

```bash
php artisan key:generate
```

## Database Setup

```bash
php artisan migrate --seed
```

## Running the Server

```bash
# Start development server
php artisan serve
```

## API Documentation

Import the Postman collection from `/postman/SBCMS_API.postman_collection.json`

Make sure you set Auth Type is `Bearer Token` and provide your token for authorization.
