<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\PackageSubscription;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Contracts\Auth\MustVerifyEmail;
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $user_type
 * @property string|null $phone
 * @property string|null $avatar
 * @property bool $is_active
 * @property \Carbon\Carbon|null $email_verified_at
 * @property \Carbon\Carbon|null $last_login_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read UserProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|UserEducation[] $education
 * @property-read \Illuminate\Database\Eloquent\Collection|UserExperience[] $experience
 * @property-read \Illuminate\Database\Eloquent\Collection|UserSkill[] $skills
 * @property-read \Illuminate\Database\Eloquent\Collection|UserLanguage[] $languages
 * @property-read \Illuminate\Database\Eloquent\Collection|UserCertification[] $certifications
 * @property-read \Illuminate\Database\Eloquent\Collection|UserResume[] $resumes
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * User type constants.
     */
    public const TYPE_ADMIN = 'admin';
    public const TYPE_EMPLOYER = 'employer';
    public const TYPE_JOB_SEEKER = 'job_seeker';
    public const TYPE_SERVICE_USER = 'service_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'phone',
        'country_code',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's profile.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the user's education records.
     */
    public function education(): HasMany
    {
        return $this->hasMany(UserEducation::class)->orderByDesc('start_date');
    }

    /**
     * Get the user's experience records.
     */
    public function experience(): HasMany
    {
        return $this->hasMany(UserExperience::class)->orderByDesc('start_date');
    }

    /**
     * Get the user's skills.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(UserSkill::class);
    }

    /**
     * Get the user's languages.
     */
    public function languages(): HasMany
    {
        return $this->hasMany(UserLanguage::class);
    }

    /**
     * Get the user's certifications.
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(UserCertification::class)->orderByDesc('issue_date');
    }

    /**
     * Get the user's resumes.
     */
    public function resumes(): HasMany
    {
        return $this->hasMany(UserResume::class)->orderByDesc('is_primary');
    }

    /**
     * Get the primary resume for the user.
     */
    public function primaryResume(): HasOne
    {
        return $this->hasOne(UserResume::class)->where('is_primary', true)->latestOfMany();
    }

    /**
     * Get the company owned by the employer.
     */
    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    /**
     * Get the jobs posted by the employer.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Get the job applications made by the job seeker.
     */
    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Get the saved jobs for the job seeker.
     */
    public function savedJobs(): HasMany
    {
        return $this->hasMany(SavedJob::class);
    }

    /**
     * Get the job alerts for the job seeker.
     */
    public function jobAlerts(): HasMany
    {
        return $this->hasMany(JobAlert::class);
    }

    /**
     * Get the user's documents.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(UserDocument::class)->orderBy('document_number');
    }

    /**
     * Get the student profile.
     */
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * Get the student documents.
     */
    public function studentDocuments(): HasMany
    {
        return $this->hasMany(StudentDocument::class);
    }

    /**
     * Get the program applications.
     */
    public function programApplications(): HasMany
    {
        return $this->hasMany(ProgramApplication::class);
    }

    /**
     * Get the user's package subscriptions.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(PackageSubscription::class);
    }

    /**
     * Get the blogs authored by the user.
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Get the blogs reviewed by the admin.
     */
    public function reviewedBlogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'reviewed_by');
    }

    /**
     * Convenience accessor for the user's active subscription.
     */
    public function getActiveSubscriptionAttribute(): ?PackageSubscription
    {
        return $this->subscriptions
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->sortByDesc('expires_at')
            ->first();
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->user_type === self::TYPE_ADMIN;
    }

    /**
     * Check if user is an employer.
     */
    public function isEmployer(): bool
    {
        return $this->user_type === self::TYPE_EMPLOYER;
    }

    /**
     * Check if user is a job seeker.
     */
    public function isJobSeeker(): bool
    {
        return $this->user_type === self::TYPE_JOB_SEEKER;
    }

    /**
     * Check if user is an educational institution.
     */
    public function isEducationalInstitution(): bool
    {
        return $this->user_type === 'educational_institution';
    }

    /**
     * Check if user is a content creator (employer or educational institution).
     */
    public function isContentCreator(): bool
    {
        return $this->hasRole(['employer', 'educational_institution']);
    }

    /**
     * Check if user is a service user.
     */
    public function isServiceUser(): bool
    {
        return $this->user_type === self::TYPE_SERVICE_USER;
    }

    /**
     * Get the police certificate applications for the user.
     */
    public function policeCertificateApplications(): HasMany
    {
        return $this->hasMany(PoliceCertificateApplication::class);
    }

    /**
     * Get the user's referral code.
     */
    public function referralCode(): HasOne
    {
        return $this->hasOne(ReferralCode::class);
    }

    /**
     * Get the user's wallet.
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get or create the user's wallet.
     */
    public function getOrCreateWallet(): Wallet
    {
        return $this->wallet ?? Wallet::create([
            'user_id' => $this->id,
            'balance' => 0,
            'currency' => config('referral.currency', 'EUR'),
        ]);
    }

    /**
     * Get the authorized partner record for the user.
     */
    public function authorizedPartner(): HasOne
    {
        return $this->hasOne(AuthorizedPartner::class);
    }

    /**
     * Get the user's appointments.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Check if user is an active authorized partner.
     */
    public function isAuthorizedPartner(): bool
    {
        return $this->authorizedPartner && $this->authorizedPartner->isActive();
    }

    /**
     * Update the last login timestamp.
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by user type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('user_type', $type);
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the email verification notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        // Use our custom verification system
        if (empty($this->verification_token)) {
            $this->verification_token = \Illuminate\Support\Str::random(64);
            $this->save();
        }

        // Temporarily use sync queue for immediate delivery
        $originalQueue = config('queue.default');
        config(['queue.default' => 'sync']);

        \Illuminate\Support\Facades\Mail::send('emails.verify', 
            ['token' => $this->verification_token, 'user' => $this], 
            function ($message) {
                $message->to($this->email);
                $message->subject('Verify Your Email Address');
            }
        );

        config(['queue.default' => $originalQueue]);
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }
}
