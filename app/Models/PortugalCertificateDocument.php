<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortugalCertificateDocument extends Model
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
        return $this->belongsTo(PortugalCertificateApplication::class, 'application_id');
    }

    public function getDocumentTypeLabelAttribute(): string
    {
        return match($this->document_type) {
            'passport' => 'Passport',
            'residence_permit' => 'Residence Permit',
            'nif_document' => 'NIF Document',
            'receipt' => 'Payment Receipt',
            default => ucfirst(str_replace('_', ' ', $this->document_type)),
        };
    }
}
