# PlaceMeNet - Deployment Guide

## Laravel Cloud Deployment

### Prerequisites
- PHP 8.2+
- MySQL 8.0+ or PostgreSQL
- Composer
- Node.js 18+ (for asset compilation)

### Deployment Steps

#### 1. Upload and Extract
Upload `placemenet.zip` to your server and extract it.

#### 2. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

#### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

#### 4. Configure .env
Edit `.env` file with your settings:
- `APP_URL` - Your domain
- `DB_*` - Database credentials
- `MAIL_*` - Mail server settings

#### 5. Database Setup
```bash
php artisan migrate --force
php artisan db:seed --force
```

#### 6. Storage Setup
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

#### 7. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Default Admin Credentials
- **Email:** admin@placemenet.com
- **Password:** password

**Important:** Change the admin password immediately after first login!

### Directory Permissions
Ensure these directories are writable:
- `storage/`
- `bootstrap/cache/`

### Cron Job (Optional)
For scheduled tasks, add this cron entry:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Queue Worker (Optional)
For background jobs:
```bash
php artisan queue:work --daemon
```

### Features Included
- Job Seeker Portal (profile, applications, saved jobs, job alerts)
- Employer Portal (company profile, job posting, applicant management)
- Admin Panel (user management, categories, settings)
- Job Search with filters
- Application tracking
- Resume management

### Support
For issues, please check Laravel documentation at https://laravel.com/docs
