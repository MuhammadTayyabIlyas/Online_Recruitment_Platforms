<?php

namespace App\Http\Requests\JobSeeker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cover_letter' => [
                'required',
                'string',
                'min:50',
                'max:2000',
            ],
            'resume' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:2048', // 2MB max
            ],
            'answers' => [
                'nullable',
                'array',
                'max:50', // Limit number of answers
            ],
            'answers.*' => [
                'required',
                'string',
                'max:5000', // Limit answer length
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume.max' => 'Resume file size must not exceed 2MB.',
            'cover_letter.min' => 'Cover letter must be at least 50 characters.',
            'cover_letter.max' => 'Cover letter must not exceed 2000 characters.',
            'answers.max' => 'Too many answers provided.',
            'answers.*.max' => 'Each answer must not exceed 5000 characters.',
        ];
    }
}
