# LinkedIn OAuth Setup Guide

## Overview
Follow these steps to enable LinkedIn login on your PlaceMeNet platform.

---

## Step 1: Create LinkedIn App

1. Go to [LinkedIn Developers Portal](https://www.linkedin.com/developers/)
2. Sign in with your LinkedIn account
3. Click "Create App" or "My Apps"
4. Fill in the app details:
   - **App name**: PlaceMeNet
   - **LinkedIn Page**: Select or create a company page
   - **App logo**: Upload your platform logo
   - **Privacy policy URL**: https://www.placemenet.net/privacy
   - **Terms of use**: https://www.placemenet.net/terms

---

## Step 2: Configure OAuth Settings

In your LinkedIn app dashboard:

1. Go to **Auth** tab
2. Find **OAuth 2.0 settings**
3. Add authorized redirect URL:
   ```
   https://www.placemenet.net/auth/linkedin/callback
   ```
4. Save settings

---

## Step 3: Get Credentials

1. Go to **Auth** tab
2. Copy your **Client ID** (looks like: `86abc123def456`)
3. Generate **Client Secret** (looks like: `AbCdEfGhIjKlMnOpQr`)
4. Save both securely

---

## Step 4: Add to .env File

Add these lines to your `.env` file:

```env
# LinkedIn OAuth Configuration
LINKEDIN_CLIENT_ID=your_client_id_here
LINKEDIN_CLIENT_SECRET=your_client_secret_here
LINKEDIN_REDIRECT_URI=https://www.placemenet.net/auth/linkedin/callback

# Optional: Set to true in production
LINKEDIN_LOGIN_ENABLED=true
```

---

## Step 5: Run Database Migration

```bash
php artisan migrate --path=database/migrations/enhanced_auth
```

This adds the `linkedin_id` column to users table.

---

## Step 6: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Step 7: Test LinkedIn Login

1. Go to your login page
2. Click "Continue with LinkedIn" button
3. Complete LinkedIn authorization
4. You should be redirected to job seeker dashboard

---

## Features

- ✅ Automatic user creation if first-time login
- ✅ Links existing email accounts to LinkedIn
- ✅ Always assigns "job_seeker" role
- ✅ Creates basic profile for job seeker
- ✅ Stores LinkedIn profile URL
- ✅ Stores LinkedIn avatar (profile photo)
- ✅ Safe fallback to regular login if OAuth fails
- ✅ Secure session handling via Laravel Sanctum

---

## User Flow

```
User clicks "Continue with LinkedIn"
    ↓
Redirected to LinkedIn authorization page
    ↓
User grants permission
    ↓
Redirected back to callback URL
    ↓
System checks if user exists:
    • By LinkedIn ID → Login existing user
    • By Email → Link to existing account
    • Neither → Create new job_seeker account
    ↓
Automatic login
    ↓
Redirected to jobseeker/dashboard
```

---

## Troubleshooting

### "Client authentication failed"
- Check Client ID and Client Secret in .env
- Ensure no extra spaces
- Verify credentials match LinkedIn app

### "Redirect URI mismatch"
- Verify redirect URL in LinkedIn app settings
- Must match exactly: `/auth/linkedin/callback`
- Include https:// and correct domain

### "User not created"
- Check storage/logs/laravel.log for errors
- Verify database migrations ran
- Ensure User model has fillable fields

---

## Security Notes

- Client Secret should never be committed to version control
- Use environment variables in production
- LinkedIn login always creates verified accounts (LinkedIn verifies emails)
- Random passwords generated for LinkedIn users (not used, OAuth handles auth)
- Session security provided by Laravel Sanctum

---

## Ready to Use!

Once configured, the LinkedIn button will appear on your login page automatically.
