# PlaceMeNet

<p align="center">
  <img src="public/assets/images/logo.png" alt="PlaceMeNet Logo" width="200">
</p>

<p align="center">
  <strong>A comprehensive job placement and educational institution platform</strong>
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#tech-stack">Tech Stack</a> •
  <a href="#architecture">Architecture</a> •
  <a href="#installation">Installation</a> •
  <a href="#project-structure">Project Structure</a>
</p>

---

## Overview

PlaceMeNet is a full-featured recruitment and education platform that connects job seekers, employers, educational institutions, and students. Built with Laravel 11 and modern web technologies, it provides a seamless experience for job placements, visa/residency services, and study programs abroad.

**Headquarters:** Alimos, Greece

## Features

### For Job Seekers
- **Profile Management** - Build comprehensive profiles with education, experience, skills, languages, and certifications
- **Resume Builder** - Upload multiple resumes with primary designation
- **Job Search** - Advanced search with filters (location, salary, job type, industry)
- **Job Applications** - Apply to jobs with cover letters and track application status
- **Saved Jobs & Alerts** - Save favorite jobs and create custom job alerts
- **Document Management** - Securely upload and manage documents

### For Employers
- **Company Profiles** - Create and manage company profiles with media
- **Job Posting** - Multi-step job creation wizard with rich details
- **Applicant Tracking** - Review, shortlist, accept, or reject candidates
- **CV Database Access** - Search and download candidate CVs with MeiliSearch
- **Subscription Packages** - Credit-based system for job postings and features

### For Educational Institutions
- **Program Management** - Create and manage study programs
- **Application Processing** - Review and process student applications
- **Multi-step Wizards** - Intuitive program creation workflow

### For Students
- **Study Program Search** - Find programs by country, degree, subject
- **Application System** - Apply to multiple programs
- **Document Upload** - Submit required documents securely

### For Administrators
- **Filament Admin Panel** - Modern, feature-rich admin interface
- **User Management** - Manage all user types and roles
- **Content Moderation** - Review and approve blog posts
- **Analytics Dashboard** - Track platform metrics and growth
- **Package Management** - Configure subscription packages
- **Police Certificate Management** - Process UK Police Certificate applications

### Police Certificate Service
- **Application Processing** - Manage UK Police Certificate applications
- **Document Management** - View and download applicant documents (passport, CNIC, BRP, receipts)
- **Status Workflow** - Track applications through: Submitted → Payment Pending → Payment Verified → Processing → Completed
- **Email Notifications** - Automatic status update emails to applicants
- **CSV Export** - Export applications with filters for reporting
- **Admin Notes** - Timestamped internal notes for each application

### Additional Features
- **Blog System** - Content creation with admin review workflow
- **Multi-language Support** - Localization ready
- **LinkedIn OAuth** - Social authentication
- **Stripe Payments** - Secure payment processing
- **Email Notifications** - Automated email workflows

---

## Tech Stack

| Category | Technology |
|----------|------------|
| **Backend Framework** | Laravel 11.31 |
| **PHP Version** | 8.2+ |
| **Frontend** | Blade, Livewire 3.0, Alpine.js |
| **CSS Framework** | Tailwind CSS 3.4 |
| **Build Tool** | Vite 6.0 |
| **Admin Panel** | Filament 3.0 |
| **Database** | MySQL |
| **Search Engine** | MeiliSearch + Laravel Scout |
| **Authentication** | Laravel Sanctum, Socialite |
| **Authorization** | Spatie Laravel Permission |
| **File Management** | Spatie Media Library |
| **Payments** | Stripe |
| **PDF Generation** | Laravel DomPDF |
| **Image Processing** | Intervention Image |
| **Debugging** | Laravel Telescope, Debugbar |

---

## Architecture

### System Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                              CLIENT LAYER                                    │
├─────────────────────────────────────────────────────────────────────────────┤
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐        │
│  │  Job Seeker │  │  Employer   │  │  Student    │  │ Institution │        │
│  │  Dashboard  │  │  Dashboard  │  │  Dashboard  │  │  Dashboard  │        │
│  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘        │
│         │                │                │                │                │
│         └────────────────┴────────────────┴────────────────┘                │
│                                   │                                          │
│                    ┌──────────────┴──────────────┐                          │
│                    │     Livewire Components     │                          │
│                    │  (Reactive UI / Real-time)  │                          │
│                    └──────────────┬──────────────┘                          │
└───────────────────────────────────┼─────────────────────────────────────────┘
                                    │
┌───────────────────────────────────┼─────────────────────────────────────────┐
│                          APPLICATION LAYER                                   │
├───────────────────────────────────┼─────────────────────────────────────────┤
│                                   ▼                                          │
│  ┌─────────────────────────────────────────────────────────────────────┐    │
│  │                         ROUTING (web.php)                            │    │
│  │   • Public Routes (jobs, programs, blog)                            │    │
│  │   • Auth Routes (login, register, verify)                           │    │
│  │   • Protected Routes (dashboards, applications)                     │    │
│  └──────────────────────────────────┬──────────────────────────────────┘    │
│                                     │                                        │
│  ┌──────────────────────────────────┼──────────────────────────────────┐    │
│  │                           MIDDLEWARE                                 │    │
│  │  ┌─────────┐ ┌─────────┐ ┌──────────────┐ ┌───────────────────┐    │    │
│  │  │  Auth   │ │  Role   │ │   Verified   │ │    Permission     │    │    │
│  │  └─────────┘ └─────────┘ └──────────────┘ └───────────────────┘    │    │
│  └──────────────────────────────────┬──────────────────────────────────┘    │
│                                     │                                        │
│  ┌──────────────────────────────────┴──────────────────────────────────┐    │
│  │                          CONTROLLERS                                 │    │
│  │  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐  │    │
│  │  │  Admin   │ │ Employer │ │JobSeeker │ │ Student  │ │Institut. │  │    │
│  │  └──────────┘ └──────────┘ └──────────┘ └──────────┘ └──────────┘  │    │
│  └──────────────────────────────────┬──────────────────────────────────┘    │
│                                     │                                        │
│  ┌──────────────────────────────────┴──────────────────────────────────┐    │
│  │                           SERVICES                                   │    │
│  │           ┌─────────────────────────────────────┐                   │    │
│  │           │       SubscriptionService           │                   │    │
│  │           │   (Business Logic & Validation)     │                   │    │
│  │           └─────────────────────────────────────┘                   │    │
│  └──────────────────────────────────┬──────────────────────────────────┘    │
└─────────────────────────────────────┼───────────────────────────────────────┘
                                      │
┌─────────────────────────────────────┼───────────────────────────────────────┐
│                             DATA LAYER                                       │
├─────────────────────────────────────┼───────────────────────────────────────┤
│                                     ▼                                        │
│  ┌─────────────────────────────────────────────────────────────────────┐    │
│  │                      ELOQUENT MODELS (38+)                          │    │
│  │  ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐            │    │
│  │  │  User  │ │  Job   │ │Company │ │Program │ │  Blog  │  ...       │    │
│  │  └────────┘ └────────┘ └────────┘ └────────┘ └────────┘            │    │
│  └──────────────────────────────────┬──────────────────────────────────┘    │
│                                     │                                        │
│         ┌───────────────────────────┼───────────────────────────────┐       │
│         ▼                           ▼                               ▼       │
│  ┌─────────────┐           ┌─────────────┐                 ┌─────────────┐  │
│  │    MySQL    │           │ MeiliSearch │                 │Media Library│  │
│  │  Database   │           │   (Search)  │                 │   (Files)   │  │
│  └─────────────┘           └─────────────┘                 └─────────────┘  │
└─────────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────────┐
│                          EXTERNAL SERVICES                                   │
├─────────────────────────────────────────────────────────────────────────────┤
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐        │
│  │   Stripe    │  │  LinkedIn   │  │    SMTP     │  │   AWS S3    │        │
│  │  Payments   │  │    OAuth    │  │    Mail     │  │  (Optional) │        │
│  └─────────────┘  └─────────────┘  └─────────────┘  └─────────────┘        │
└─────────────────────────────────────────────────────────────────────────────┘
```

### User Roles & Access Flow

```
                                    ┌──────────────┐
                                    │   Visitor    │
                                    └──────┬───────┘
                                           │
                              ┌────────────┴────────────┐
                              │      Registration       │
                              └────────────┬────────────┘
                                           │
           ┌───────────────┬───────────────┼───────────────┬───────────────┐
           ▼               ▼               ▼               ▼               ▼
    ┌─────────────┐ ┌─────────────┐ ┌─────────────┐ ┌─────────────┐ ┌─────────────┐
    │  Job Seeker │ │  Employer   │ │   Student   │ │ Institution │ │    Admin    │
    └──────┬──────┘ └──────┬──────┘ └──────┬──────┘ └──────┬──────┘ └──────┬──────┘
           │               │               │               │               │
           ▼               ▼               ▼               ▼               ▼
    ┌─────────────┐ ┌─────────────┐ ┌─────────────┐ ┌─────────────┐ ┌─────────────┐
    │• View Jobs  │ │• Post Jobs  │ │• Browse     │ │• Create     │ │• Full       │
    │• Apply      │ │• Manage     │ │  Programs   │ │  Programs   │ │  Platform   │
    │• Profile    │ │  Applicants │ │• Apply      │ │• Review     │ │  Control    │
    │• Documents  │ │• CV Search  │ │• Documents  │ │  Students   │ │• Analytics  │
    │• Alerts     │ │• Packages   │ │             │ │             │ │• Moderation │
    └─────────────┘ └─────────────┘ └─────────────┘ └─────────────┘ └─────────────┘
```

### Database Schema (Core Entities)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                              DATABASE SCHEMA                                 │
└─────────────────────────────────────────────────────────────────────────────┘

┌──────────────────┐       ┌──────────────────┐       ┌──────────────────┐
│      users       │       │   job_listings   │       │    companies     │
├──────────────────┤       ├──────────────────┤       ├──────────────────┤
│ id               │       │ id               │       │ id               │
│ name             │──┐    │ company_id       │───────│ user_id          │
│ email            │  │    │ title            │       │ name             │
│ role (enum)      │  │    │ slug             │       │ logo             │
│ email_verified   │  │    │ description      │       │ description      │
│ phone            │  │    │ location         │       │ website          │
│ linkedin_id      │  │    │ salary_min/max   │       │ industry         │
└──────────────────┘  │    │ job_type_id      │       └──────────────────┘
         │            │    │ status           │
         │            │    │ is_featured      │
         │            │    │ deleted_at       │
         │            │    └──────────────────┘
         │            │             │
         │            │             │
         ▼            │             ▼
┌──────────────────┐  │    ┌──────────────────┐
│  user_profiles   │  │    │ job_applications │
├──────────────────┤  │    ├──────────────────┤
│ user_id          │◄─┤    │ id               │
│ headline         │  │    │ job_id           │
│ bio              │  │    │ user_id          │◄──────────────────────────┐
│ location         │  │    │ status (enum)    │                           │
│ avatar           │  │    │ cover_letter     │                           │
└──────────────────┘  │    │ notes            │                           │
                      │    └──────────────────┘                           │
┌──────────────────┐  │                                                   │
│  user_education  │  │    ┌──────────────────┐       ┌──────────────────┐│
├──────────────────┤  │    │     programs     │       │program_applications│
│ user_id          │◄─┤    ├──────────────────┤       ├──────────────────┤│
│ institution      │  │    │ id               │       │ id               ││
│ degree           │  │    │ institution_id   │       │ program_id       ││
│ field            │  │    │ name             │       │ user_id          │┘
│ start/end_date   │  │    │ degree_type      │       │ status           │
└──────────────────┘  │    │ duration         │       │ documents        │
                      │    │ tuition_fee      │       └──────────────────┘
┌──────────────────┐  │    └──────────────────┘
│ user_experience  │  │
├──────────────────┤  │    ┌──────────────────┐       ┌──────────────────┐
│ user_id          │◄─┤    │     packages     │       │package_subscriptions│
│ company          │  │    ├──────────────────┤       ├──────────────────┤
│ title            │  │    │ id               │       │ id               │
│ description      │  │    │ name             │       │ user_id          │◄─┘
│ start/end_date   │  │    │ price            │       │ package_id       │
└──────────────────┘  │    │ job_posts        │       │ expires_at       │
                      │    │ featured_posts   │       │ credits_used     │
┌──────────────────┐  │    │ cv_downloads     │       └──────────────────┘
│   user_skills    │  │    └──────────────────┘
├──────────────────┤  │
│ user_id          │◄─┤    ┌──────────────────┐       ┌──────────────────┐
│ skill_id         │  │    │      blogs       │       │  blog_categories │
│ is_required      │  │    ├──────────────────┤       ├──────────────────┤
└──────────────────┘  │    │ id               │       │ id               │
                      │    │ user_id          │◄──────│ name             │
┌──────────────────┐  │    │ category_id      │───────│ slug             │
│  user_resumes    │  │    │ title            │       │ is_active        │
├──────────────────┤  │    │ content          │       └──────────────────┘
│ user_id          │◄─┘    │ status (enum)    │
│ file_path        │       │ published_at     │
│ is_primary       │       └──────────────────┘
└──────────────────┘
```

---

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 8.0+
- MeiliSearch (optional, for advanced search)

### Setup Steps

```bash
# 1. Clone the repository
git clone git@github.com:MuhammadTayyabIlyas/Online_Recruitment_Platforms.git
cd Online_Recruitment_Platforms

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Environment setup
cp .env.example .env
php artisan key:generate

# 5. Configure your .env file
# - Set database credentials (DB_*)
# - Set mail configuration (MAIL_*)
# - Set Stripe keys (STRIPE_*)
# - Set LinkedIn OAuth (LINKEDIN_*)

# 6. Run migrations and seeders
php artisan migrate
php artisan db:seed

# 7. Create storage link
php artisan storage:link

# 8. Build frontend assets
npm run build

# 9. Start the application
composer run dev
```

### Environment Variables

| Variable | Description |
|----------|-------------|
| `DB_CONNECTION` | Database driver (mysql) |
| `DB_HOST` | Database host |
| `DB_DATABASE` | Database name |
| `DB_USERNAME` | Database user |
| `DB_PASSWORD` | Database password |
| `MAIL_MAILER` | Mail driver (smtp) |
| `MAIL_HOST` | SMTP server |
| `MAIL_PORT` | SMTP port |
| `MAIL_USERNAME` | SMTP username |
| `MAIL_PASSWORD` | SMTP password |
| `STRIPE_KEY` | Stripe publishable key |
| `STRIPE_SECRET` | Stripe secret key |
| `LINKEDIN_CLIENT_ID` | LinkedIn OAuth client ID |
| `LINKEDIN_CLIENT_SECRET` | LinkedIn OAuth secret |
| `MEILISEARCH_HOST` | MeiliSearch server URL |
| `MEILISEARCH_KEY` | MeiliSearch API key |

---

## Project Structure

```
placemenet/
├── app/
│   ├── Console/Commands/      # Artisan commands (SendJobAlerts)
│   ├── Enums/                 # PHP enums (ApplicationStatus, BlogStatus)
│   ├── Filament/              # Admin panel resources
│   │   ├── Pages/             # Custom admin pages
│   │   ├── Resources/         # CRUD resources
│   │   └── Widgets/           # Dashboard widgets
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # Admin controllers
│   │   │   ├── Auth/          # Authentication controllers
│   │   │   ├── ContentCreator/# Blog management
│   │   │   ├── Employer/      # Employer controllers
│   │   │   ├── Institution/   # Institution controllers
│   │   │   ├── JobSeeker/     # Job seeker controllers
│   │   │   └── Student/       # Student controllers
│   │   ├── Middleware/        # Custom middleware
│   │   └── Requests/          # Form request validation
│   ├── Livewire/              # Livewire components
│   │   ├── JobSearch.php      # Job search with filters
│   │   ├── StudyProgramSearch.php
│   │   ├── JobPostingWizard.php
│   │   └── Institution/       # Institution components
│   ├── Mail/                  # Mailable classes
│   ├── Models/                # Eloquent models (38+)
│   ├── Notifications/         # Notification classes
│   ├── Policies/              # Authorization policies
│   ├── Providers/             # Service providers
│   └── Services/              # Business logic services
├── config/
│   ├── placemenet.php         # App-specific config
│   └── ...                    # Laravel config files
├── database/
│   ├── factories/             # Model factories
│   ├── migrations/            # Database migrations (60+)
│   └── seeders/               # Database seeders
├── public/
│   └── assets/                # Public assets
├── resources/
│   ├── css/                   # Stylesheets
│   ├── js/                    # JavaScript
│   ├── lang/                  # Localization files
│   └── views/
│       ├── components/        # Blade components
│       ├── content-creator/   # Blog views
│       ├── emails/            # Email templates
│       ├── employer/          # Employer views
│       ├── filament/          # Admin customizations
│       ├── institution/       # Institution views
│       ├── jobseeker/         # Job seeker views
│       ├── layouts/           # Layout templates
│       ├── livewire/          # Livewire views
│       └── student/           # Student views
├── routes/
│   ├── web.php                # Web routes (400+ lines)
│   ├── auth.php               # Authentication routes
│   └── console.php            # Console routes
├── storage/                   # File storage
├── tests/
│   ├── Feature/               # Feature tests
│   └── Unit/                  # Unit tests
├── CLAUDE.md                  # AI assistant guidance
└── composer.json              # PHP dependencies
```

---

## Development

### Running Development Server

```bash
# Start all services (recommended)
composer run dev

# This runs concurrently:
# - Laravel server (http://localhost:8000)
# - Queue worker
# - Log viewer (pail)
# - Vite dev server
```

### Common Commands

```bash
# Database
php artisan migrate              # Run migrations
php artisan migrate:fresh --seed # Fresh database with seeds
php artisan tinker               # Interactive shell

# Cache
php artisan config:clear         # Clear config cache
php artisan cache:clear          # Clear app cache
php artisan view:clear           # Clear compiled views
php artisan route:clear          # Clear route cache

# Testing
php artisan test                 # Run all tests
php artisan test --filter=Name   # Run specific test

# Code Quality
./vendor/bin/pint                # Fix code style

# Assets
npm run dev                      # Development build
npm run build                    # Production build
```

### Access Points

| URL | Description |
|-----|-------------|
| `http://localhost:8000` | Main application |
| `http://localhost:8000/admin` | Admin dashboard (custom) |
| `http://localhost:8000/admin/police-certificates` | Police Certificate management |
| `http://localhost:8000/panel` | Filament admin panel |
| `http://localhost:8000/telescope` | Laravel Telescope (debug) |

---

## License

This project is proprietary software. All rights reserved.

---

## Support

- **Email:** support@placemenet.net
- **Legal:** legal@placemenet.net
- **WhatsApp:** +30 698 151 3600
