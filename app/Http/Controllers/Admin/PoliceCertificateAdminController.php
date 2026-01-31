<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoliceCertificateApplication;
use App\Models\PoliceCertificateDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PoliceCertificateAdminController extends Controller
{
    public function downloadDocument(PoliceCertificateDocument $document)
    {
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'Document not found');
        }

        return Storage::disk('private')->download(
            $document->file_path,
            $document->original_filename
        );
    }

    public function previewDocument(PoliceCertificateDocument $document)
    {
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'Document not found');
        }

        $mimeType = $document->mime_type;
        $content = Storage::disk('private')->get($document->file_path);

        return response($content)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $document->original_filename . '"');
    }

    public function downloadAllDocuments(PoliceCertificateApplication $application)
    {
        $documents = $application->documents;

        if ($documents->isEmpty()) {
            return back()->with('error', 'No documents found for this application.');
        }

        $zipFileName = 'PCC_' . $application->application_reference . '_documents.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Could not create zip file.');
        }

        foreach ($documents as $document) {
            if (Storage::disk('private')->exists($document->file_path)) {
                $content = Storage::disk('private')->get($document->file_path);
                $fileName = $document->document_type . '_' . $document->original_filename;
                $zip->addFromString($fileName, $content);
            }
        }

        $zip->close();

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }
}
