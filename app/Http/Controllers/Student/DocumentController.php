<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = StudentDocument::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $documentTypes = StudentDocument::getDocumentTypes();

        return view('student.documents.index', compact('documents', 'documentTypes'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'document' => ['required', 'file', 'mimes:pdf', 'max:5120'], // 5MB
            'document_type' => ['required', 'string'],
            'document_name' => ['required', 'string', 'max:255'],
        ]);

        // Check limit (max 15 documents)
        $count = StudentDocument::where('user_id', Auth::id())->count();
        if ($count >= 15) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum 15 documents allowed'
            ], 400);
        }

        $file = $request->file('document');
        $path = $file->store('student-documents', 'private');

        $document = StudentDocument::create([
            'user_id' => Auth::id(),
            'document_type' => $request->document_type,
            'document_name' => $request->document_name,
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully',
            'document' => $document->load('user'),
        ]);
    }

    public function download(StudentDocument $document)
    {
        // Authorization
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        return Storage::disk('private')->download($document->file_path, $document->original_filename);
    }

    public function destroy(StudentDocument $document)
    {
        // Authorization
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('private')->delete($document->file_path);
        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document deleted successfully'
        ]);
    }
}
