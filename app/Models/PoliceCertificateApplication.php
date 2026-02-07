<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PoliceCertificateApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'father_full_name',
        'gender',
        'date_of_birth',
        'place_of_birth_city',
        'place_of_birth_country',
        'nationality',
        'marital_status',
        'passport_number',
        'passport_issue_date',
        'passport_expiry_date',
        'passport_place_of_issue',
        'cnic_nicop_number',
        'uk_home_office_ref',
        'uk_brp_number',
        'uk_residence_history',
        'uk_national_insurance_number',
        'uk_address_history',
        'spain_address_line1',
        'spain_address_line2',
        'spain_city',
        'spain_province',
        'spain_postal_code',
        'email',
        'phone_spain',
        'whatsapp_number',
        'service_type',
        'payment_currency',
        'payment_amount',
        'payment_status',
        'payment_verified_at',
        'payment_verified_by',
        'status',
        'application_reference',
        'submitted_at',
        'admin_notes',
        'disclaimer_accepted_at',
        'signature_data',
        'signature_place',
        'signature_date',
        'signature_method',
        'authorization_letter_uploaded',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'passport_issue_date' => 'date',
        'passport_expiry_date' => 'date',
        'payment_amount' => 'decimal:2',
        'payment_verified_at' => 'datetime',
        'submitted_at' => 'datetime',
        'disclaimer_accepted_at' => 'datetime',
        'uk_residence_history' => 'array',
        'uk_address_history' => 'array',
        'signature_date' => 'date',
        'authorization_letter_uploaded' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            if (empty($application->application_reference)) {
                $application->application_reference = 'PCC-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(PoliceCertificateDocument::class, 'application_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'payment_verified_by');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . ($this->middle_name ? $this->middle_name . ' ' : '') . $this->last_name;
    }

    public function getServiceTypeLabelAttribute()
    {
        return $this->service_type === 'normal' ? 'Normal (14 days)' : 'Urgent (7 days)';
    }

    public function getPaymentAmountDisplayAttribute()
    {
        $currency = strtoupper($this->payment_currency);
        return $currency === 'GBP' ? '£' . $this->payment_amount : '€' . $this->payment_amount;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'payment_pending' => 'Payment Pending',
            'payment_verified' => 'Payment Verified',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'rejected' => 'Rejected',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'draft' => 'gray',
            'submitted' => 'blue',
            'payment_pending' => 'yellow',
            'payment_verified' => 'green',
            'processing' => 'indigo',
            'completed' => 'emerald',
            'rejected' => 'red',
        ];
        return $colors[$this->status] ?? 'gray';
    }

    public function passportDocument()
    {
        return $this->documents()->where('document_type', 'passport')->first();
    }

    public function cnicDocument()
    {
        return $this->documents()->where('document_type', 'cnic')->first();
    }

    public function brpDocument()
    {
        return $this->documents()->where('document_type', 'brp')->first();
    }

    public function receiptDocument()
    {
        return $this->documents()->where('document_type', 'receipt')->first();
    }

    public function photoDocument()
    {
        return $this->documents()->where('document_type', 'photo')->first();
    }

    public function selfiePassportDocument()
    {
        return $this->documents()->where('document_type', 'selfie_passport')->first();
    }
}