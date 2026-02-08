<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GreeceCertificateApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'father_name',
        'mother_name',
        'gender',
        'date_of_birth',
        'place_of_birth_city',
        'place_of_birth_country',
        'nationality',
        'passport_number',
        'passport_issue_date',
        'passport_expiry_date',
        'passport_place_of_issue',
        'greece_afm',
        'greece_amka',
        'greece_residence_permit',
        'greece_residence_permit_expiry',
        'greece_residence_history',
        'current_address_line1',
        'current_address_line2',
        'current_city',
        'current_postal_code',
        'current_country',
        'email',
        'phone_number',
        'whatsapp_number',
        'authorization_letter_uploaded',
        'signature_data',
        'signature_place',
        'signature_date',
        'signature_method',
        'certificate_purpose',
        'purpose_details',
        'service_type',
        'payment_currency',
        'payment_amount',
        'payment_status',
        'payment_verified_at',
        'payment_verified_by',
        'status',
        'application_reference',
        'admin_notes',
        'referral_code_used',
        'disclaimer_accepted_at',
        'submitted_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'passport_issue_date' => 'date',
        'passport_expiry_date' => 'date',
        'greece_residence_permit_expiry' => 'date',
        'authorization_letter_uploaded' => 'boolean',
        'signature_date' => 'date',
        'payment_amount' => 'decimal:2',
        'payment_verified_at' => 'datetime',
        'submitted_at' => 'datetime',
        'disclaimer_accepted_at' => 'datetime',
        'greece_residence_history' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            if (empty($application->application_reference)) {
                $application->application_reference = 'GR-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(GreeceCertificateDocument::class, 'application_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'payment_verified_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'payment_pending' => 'Payment Pending',
            'payment_verified' => 'Payment Verified',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'rejected' => 'Rejected',
            default => ucfirst($this->status),
        };
    }

    public function getPurposeLabelAttribute(): string
    {
        return match($this->certificate_purpose) {
            'employment' => 'Employment',
            'immigration' => 'Immigration',
            'visa' => 'Visa Application',
            'residency' => 'Residency Permit',
            'education' => 'Education/Study',
            'adoption' => 'Adoption',
            'other' => 'Other',
            default => ucfirst($this->certificate_purpose ?? ''),
        };
    }

    public function getServiceTypeLabelAttribute(): string
    {
        return match($this->service_type) {
            'normal' => 'Normal Processing (5-7 days)',
            'urgent' => 'Urgent Processing (2-3 days)',
            default => ucfirst($this->service_type ?? ''),
        };
    }
}
