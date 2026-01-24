<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    /**
     * Display documents for a specific user
     */
    public function show($userId)
    {
        $user = User::with('documents')->findOrFail($userId);

        // Ensure the user is a job seeker
        if (!$user->isJobSeeker()) {
            abort(404, 'User not found.');
        }

        $documents = $user->documents;

        return view('employer.user-documents.show', compact('user', 'documents'));
    }

    /**
     * Download a user's document (secure)
     */
    public function download($documentId)
    {
        $document = UserDocument::findOrFail($documentId);

        // Ensure current employer can access CVs
        $employer = auth()->user();
        if (!$employer->company?->is_cv_access_approved) {
            abort(403, 'CV access is not enabled for your account.');
        }

        // Ensure the document belongs to a job seeker
        $owner = $document->user;
        if (!$owner || !$owner->isJobSeeker()) {
            abort(404, 'File not found.');
        }

        if (!Storage::exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($document->file_path, $document->original_name);
    }
}
