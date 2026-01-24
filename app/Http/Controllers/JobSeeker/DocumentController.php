<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display the document upload page
     */
    public function index()
    {
        $documents = auth()->user()->documents;
        return view('jobseeker.documents.index', compact('documents'));
    }

    /**
     * Get current upload status (for AJAX)
     */
    public function status()
    {
        $user = auth()->user();
        $documents = $user->documents;
        $uploadedCount = $documents->count();
        $nextDocumentNumber = $uploadedCount + 1;

        return response()->json([
            'uploaded_count' => $uploadedCount,
            'next_document_number' => $nextDocumentNumber > 10 ? null : $nextDocumentNumber,
            'can_upload_more' => $uploadedCount < 10,
            'documents' => $documents->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'document_number' => $doc->document_number,
                    'document_name' => $doc->document_name,
                    'original_name' => $doc->original_name,
                    'file_size_formatted' => $doc->file_size_formatted,
                    'uploaded_at' => $doc->created_at->format('M d, Y'),
                ];
            }),
        ]);
    }

    /**
     * Upload a new document
     */
    public function upload(Request $request)
    {
        $user = auth()->user();

        // Check if user has already uploaded 10 documents
        $uploadedCount = $user->documents()->count();
        if ($uploadedCount >= 10) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum 10 documents allowed.',
            ], 400);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'document' => 'required|file|mimes:pdf|max:5120', // 5MB max
            'document_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Auto-assign the next document number in sequence
        $documentNumber = $uploadedCount + 1;

        $file = $request->file('document');

        // Generate unique filename
        $fileName = Str::uuid() . '.pdf';
        $filePath = 'user_documents/' . $user->id . '/' . $fileName;

        // Store file
        Storage::put($filePath, file_get_contents($file));

        // Create database record
        $document = $user->documents()->create([
            'document_number' => $documentNumber,
            'document_name' => $request->input('document_name'),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Uploaded successfully. Please upload your next document.',
            'document' => [
                'id' => $document->id,
                'document_number' => $document->document_number,
                'document_name' => $document->document_name,
                'original_name' => $document->original_name,
                'file_size_formatted' => $document->file_size_formatted,
                'uploaded_at' => $document->created_at->format('M d, Y'),
            ],
            'uploaded_count' => $user->documents()->count(),
            'can_upload_more' => $user->documents()->count() < 10,
        ]);
    }

    /**
     * Download a document
     */
    public function download($id)
    {
        $document = UserDocument::findOrFail($id);

        // Ensure user owns this document
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if (!Storage::exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($document->file_path, $document->original_name);
    }

    /**
     * Delete a document
     */
    public function destroy($id)
    {
        $document = UserDocument::findOrFail($id);

        // Ensure user owns this document
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Delete file from storage
        if (Storage::exists($document->file_path)) {
            Storage::delete($document->file_path);
        }

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document deleted successfully.',
        ]);
    }
}
