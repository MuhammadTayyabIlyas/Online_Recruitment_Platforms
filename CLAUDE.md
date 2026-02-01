# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

PlaceMeNet is a job placement and educational institution platform built with Laravel 11. It connects job seekers, employers, educational institutions, and students for job placements, visa/residency services, and study programs abroad. Based in Greece.

## Tech Stack

- **Backend:** Laravel 11.31, PHP 8.2+
- **Frontend:** Blade, Livewire 3.0, Tailwind CSS 3.4, Alpine.js
- **Build:** Vite 6.0
- **Admin Panel:** Filament 3.0
- **Database:** MySQL
- **Search:** MeiliSearch with Laravel Scout
- **Payments:** Stripe
- **Auth:** Laravel Sanctum, Socialite (LinkedIn OAuth)
- **Permissions:** Spatie Laravel Permission
- **Media:** Spatie Media Library

## Development Commands

```bash
# Start all dev services (server, queue, logs, vite)
composer run dev

# Individual commands
php artisan serve              # Laravel dev server
php artisan queue:listen       # Process queued jobs
npm run dev                    # Vite dev server
npm run build                  # Production build

# Testing
php artisan test               # Run all tests
php artisan test --filter=TestName  # Run specific test

# Cache management
php artisan config:clear       # Clear config cache
php artisan cache:clear        # Clear application cache
php artisan view:clear         # Clear compiled views
php artisan route:clear        # Clear route cache

# After .env changes
php artisan config:clear && php artisan config:cache
```

## Architecture

### User Roles (5 types)

1. **Admin** - Full platform control via Filament admin panel at `/admin`
2. **Employer** - Post jobs, manage applicants, CV database access
3. **Job Seeker** - Apply to jobs, build profiles, manage applications
4. **Student** - Apply to study programs, manage documents
5. **Educational Institution** - Create/manage study programs

### Controller Organization

Controllers are organized by role in `app/Http/Controllers/`:
- `Admin/` - Admin dashboard, user/category/job management
- `Employer/` - Company, jobs, applicants, CV search
- `JobSeeker/` - Profile, applications, saved jobs, alerts
- `Student/` - Dashboard, profile, documents
- `Institution/` - Program management
- `ContentCreator/` - Blog management
- `Auth/` - Authentication flows

### Key Patterns

**Role-Based Middleware:** Routes protected by `role:admin`, `role:employer`, etc.

**Livewire Components:** Interactive search and multi-step wizards in `app/Livewire/`:
- `JobSearch` - Reactive job filtering
- `StudyProgramSearch` - Program filtering
- `JobPostingWizard` - Multi-step job creation
- `Institution/ProgramWizard` - Program creation

**Filament Admin:** Resources in `app/Filament/Resources/` for admin CRUD operations.

**Service Layer:** Business logic in `app/Services/` (e.g., `SubscriptionService`).

### Database

60+ migrations. Key tables:
- `users` - Core user table with role enum
- `job_listings` - Job posts (uses soft deletes)
- `job_applications` - Application tracking
- `companies` - Employer companies
- `programs` - Study programs
- `packages`, `package_subscriptions` - Subscription system
- `blogs`, `blog_categories` - Content management
- `police_certificate_applications` - UK Police Certificate applications
- `police_certificate_documents` - Uploaded documents for PCC applications

User profile split across: `user_profiles`, `user_education`, `user_experience`, `user_skills`, `user_languages`, `user_certifications`, `user_resumes`

### Police Certificate Module

Located in `app/Http/Controllers/Admin/PoliceCertificateAdminController.php`

**Routes** (prefixed with `admin.police-certificates`):
- `GET /admin/police-certificates` - List all applications with stats and filters
- `GET /admin/police-certificates/{id}` - View application details
- `PATCH /admin/police-certificates/{id}/status` - Update status (triggers email)
- `GET /admin/police-certificates/export/csv` - Export filtered data

**Views** in `resources/views/admin/police-certificates/`:
- `index.blade.php` - List view with statistics cards, filters, table
- `show.blade.php` - Detail view with all applicant info and admin controls

**Status Workflow**: `draft` → `submitted` → `payment_pending` → `payment_verified` → `processing` → `completed` (or `rejected`)

**Email Notifications**: `App\Mail\PoliceCertificateStatusUpdate` sends status update emails when admin changes application status.

### Routes

Main routes in `routes/web.php` (~400+ lines). Auth routes in `routes/auth.php`.

Dashboard redirects based on user role after login.

## Configuration

Custom app config in `config/placemenet.php` (offices, working hours, contact info).

Environment variables needed:
- Database: `DB_*`
- Mail: `MAIL_*`
- Stripe: `STRIPE_KEY`, `STRIPE_SECRET`
- LinkedIn OAuth: `LINKEDIN_CLIENT_ID`, `LINKEDIN_CLIENT_SECRET`
- MeiliSearch: `MEILISEARCH_HOST`, `MEILISEARCH_KEY` (optional)

## Admin Panels

The application has two admin interfaces:

1. **Custom Admin Panel** (`/admin`) - Primary admin dashboard
   - Located in `resources/views/admin/` and `resources/views/layouts/admin.blade.php`
   - Controllers in `app/Http/Controllers/Admin/`
   - Includes: Users, Jobs, Programs, Applications, Police Certificates, Blogs, Settings

2. **Filament Panel** (`/panel`) - Secondary admin for specific resources
   - Configuration in `app/Providers/Filament/AdminPanelProvider.php`
   - Resources in `app/Filament/Resources/`

## Debugging

- Laravel Telescope available at `/telescope`
- Laravel Debugbar enabled in development
- Logs: `php artisan pail` or `storage/logs/laravel.log`
