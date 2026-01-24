<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'nationality',
        'country_of_residence',
        'phone',
        'address',
        'current_education_level',
        'field_of_study',
        'institution_name',
        'gpa',
        'gpa_scale',
        'expected_graduation',
        'languages',
        'english_test_type',
        'english_test_score',
        'preferred_countries',
        'preferred_fields',
        'preferred_degree_levels',
        'preferred_start_date',
        'budget_min',
        'budget_max',
        'budget_currency',
        'bio',
        'achievements',
        'extracurricular',
        'work_experience',
        'profile_completion',
        'is_complete',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'gpa' => 'decimal:2',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'languages' => 'array',
        'preferred_countries' => 'array',
        'preferred_fields' => 'array',
        'preferred_degree_levels' => 'array',
        'is_complete' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculateCompletion(): int
    {
        $fields = [
            'date_of_birth', 'gender', 'nationality', 'phone',
            'current_education_level', 'field_of_study', 'institution_name',
            'gpa', 'languages', 'bio', 'preferred_countries', 'preferred_fields'
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }

        $completion = round(($filled / count($fields)) * 100);
        $this->update(['profile_completion' => $completion, 'is_complete' => $completion >= 80]);

        return $completion;
    }
}
