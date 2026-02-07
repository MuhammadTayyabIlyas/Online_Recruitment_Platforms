<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreeceCertificateDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'document_type',
        'file_path',
        'original_filename',
        'mime_type',
        'file_size',
        'description',
    ];

    public function application()
    {
        return $this->belongsTo(GreeceCertificateApplication::class, 'application_id');
    }

    public function getDocumentTypeLabelAttribute(): string
    {
        return match($this->document_type) {
            'passport' => 'Passport',
            'passport_front' => 'Passport / ID - Front Side',
            'passport_back' => 'Passport / ID - Back Side',
            'residence_permit' => 'Residence Permit',
            'authorization_letter' => 'Authorization Letter',
            'receipt' => 'Payment Receipt',
            default => ucfirst(str_replace('_', ' ', $this->document_type)),
        };
    }
}
