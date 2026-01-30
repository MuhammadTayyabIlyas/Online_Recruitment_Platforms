<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliceCertificateDocument extends Model
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
        return $this->belongsTo(PoliceCertificateApplication::class, 'application_id');
    }

    public function getDocumentTypeLabelAttribute()
    {
        $labels = [
            'passport' => 'Passport',
            'cnic' => 'CNIC/NICOP',
            'brp' => 'UK BRP/Visa',
            'receipt' => 'Payment Receipt',
            'additional' => 'Additional Document',
        ];
        return $labels[$this->document_type] ?? $this->document_type;
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}