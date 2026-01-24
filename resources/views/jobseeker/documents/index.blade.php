@extends('layouts.app')

@section('title', 'Document Upload')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Document Upload</h1>
        <p class="text-gray-600">Upload up to 10 PDF documents (max 4 MB each)</p>
    </div>

    <!-- Progress Indicator -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Progress</span>
            <span class="text-sm font-medium text-indigo-600" id="progress-text">0 / 10 documents uploaded</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300" id="progress-bar" style="width: 0%"></div>
        </div>
    </div>

    <!-- Upload Forms Container -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Upload Documents</h2>

        <!-- Success Message Area -->
        <div id="last-upload-success" class="hidden mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-green-800" id="success-message-text">Document uploaded successfully!</p>
                    <p class="text-xs text-green-700 mt-1">Please upload your next document below.</p>
                </div>
            </div>
        </div>

        <div id="upload-forms-container" class="space-y-4">
            <!-- Upload forms will be dynamically generated here -->
        </div>
    </div>

    <!-- Uploaded Documents List -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Uploaded Documents</h2>

        <div id="documents-list" class="space-y-3">
            <p class="text-gray-500 text-sm" id="no-documents-message">No documents uploaded yet.</p>
        </div>
    </div>
</div>

<style>
.upload-field {
    border: 2px dashed #d1d5db;
    border-radius: 0.5rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.upload-field.active {
    border-color: #6366f1;
    background-color: #f9fafb;
}

.upload-field.locked {
    background-color: #f3f4f6;
    opacity: 0.7;
    pointer-events: none;
}

.upload-field.success {
    border-color: #10b981;
    background-color: #f0fdf4;
}

.upload-field.error {
    border-color: #ef4444;
    background-color: #fef2f2;
}

.file-input-wrapper {
    position: relative;
    overflow: hidden;
    display: inline-block;
}

.file-input-wrapper input[type=file] {
    position: absolute;
    left: -9999px;
}

.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #6366f1;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
    display: inline-block;
    margin-right: 8px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadFormsContainer = document.getElementById('upload-forms-container');
    const documentsList = document.getElementById('documents-list');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const noDocumentsMessage = document.getElementById('no-documents-message');
    const MAX_BYTES = 5 * 1024 * 1024; // 5 MB

    let uploadedCount = 0;
    let currentDocuments = [];

    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Initialize: Load current status
    loadStatus();

    function loadStatus() {
        fetch('{{ route("jobseeker.documents.status") }}')
            .then(response => response.json())
            .then(data => {
                uploadedCount = data.uploaded_count;
                currentDocuments = data.documents;
                updateProgress();
                renderUploadForms();
                renderDocumentsList();
            })
            .catch(error => {
                console.error('Error loading status:', error);
                showNotification('Error loading document status', 'error');
            });
    }

    function updateProgress() {
        const percentage = (uploadedCount / 10) * 100;
        progressBar.style.width = percentage + '%';
        progressText.textContent = `${uploadedCount} / 10 documents uploaded`;
    }

    function renderUploadForms() {
        uploadFormsContainer.innerHTML = '';

        // If all 10 documents uploaded, show completion message
        if (uploadedCount >= 10) {
            uploadFormsContainer.innerHTML = `
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">All Documents Uploaded!</h3>
                    <p class="text-sm text-gray-600">You have successfully uploaded all 10 documents.</p>
                </div>
            `;
            return;
        }

        // Only show the next upload field (current one to upload)
        const nextNumber = uploadedCount + 1;
        const formDiv = createUploadForm(nextNumber, false, true, false);
        uploadFormsContainer.appendChild(formDiv);
    }

    function createUploadForm(number, isUploaded, isActive, isLocked) {
        const div = document.createElement('div');
        div.className = 'upload-field active';
        div.id = `upload-field-${number}`;

        div.innerHTML = `
                <div class="flex items-center justify-between mb-3">
                    <span class="font-medium text-gray-900">Document #${number}</span>
                    <span class="text-xs text-indigo-600 font-medium">Ready to upload</span>
                </div>

                <div class="mb-3">
                    <label for="doc-name-${number}" class="block text-sm font-medium text-gray-700 mb-1">Document Name *</label>
                    <input type="text" id="doc-name-${number}"
                           placeholder="e.g., Passport, Resume, Degree Certificate"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           data-doc-number="${number}">
                </div>

                <div class="flex items-center space-x-3 mb-3">
                    <div class="file-input-wrapper flex-1">
                        <label for="file-${number}" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Choose PDF File
                        </label>
                        <input type="file" id="file-${number}" accept=".pdf" data-doc-number="${number}" class="document-file-input">
                    </div>
                    <span class="text-xs text-gray-500" id="file-name-${number}">Max 5 MB</span>
                </div>

                <button type="button" id="upload-btn-${number}"
                        class="w-full px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition hidden">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Upload Document
                </button>

                <div id="message-${number}" class="mt-2"></div>
            `;

            // Attach event listeners
            const fileInput = div.querySelector(`#file-${number}`);
            const docNameInput = div.querySelector(`#doc-name-${number}`);
            const uploadBtn = div.querySelector(`#upload-btn-${number}`);

            fileInput.addEventListener('change', (e) => handleFileSelect(e, false));

            // Show upload button when both name and file are selected
            const checkUploadReady = () => {
                const hasName = docNameInput.value.trim().length > 0;
                const hasFile = fileInput.files.length > 0;
                if (hasName && hasFile) {
                    uploadBtn.classList.remove('hidden');
                } else {
                    uploadBtn.classList.add('hidden');
                }
            };

            docNameInput.addEventListener('input', checkUploadReady);
            fileInput.addEventListener('change', checkUploadReady);

            uploadBtn.addEventListener('click', async () => {
                const file = fileInput.files[0];
                if (file) {
                    await handleFileSelect({ target: fileInput }, true);
                }
            });

        return div;
    }

    async function handleFileSelect(event, autoUpload = false) {
        const file = event.target.files[0];
        const docNumber = parseInt(event.target.dataset.docNumber);

        if (!file) return;

        // Validate file type
        if (file.type !== 'application/pdf') {
            showFieldMessage(docNumber, 'Please upload a PDF file only.', 'error');
            event.target.value = '';
            return;
        }

        let fileToUpload = file;

        // Validate file size with compression attempt (5 MB)
        if (file.size > MAX_BYTES) {
            showFieldMessage(docNumber, 'File exceeds 5 MB. Attempting compression...', 'warning');
            try {
                fileToUpload = await compressPdf(file, MAX_BYTES);
                if (fileToUpload.size > MAX_BYTES) {
                    showFieldMessage(docNumber, 'File is still over 5 MB after compression. Please compress and try again.', 'error');
                    event.target.value = '';
                    return;
                } else {
                    showFieldMessage(docNumber, `Compressed to ${(fileToUpload.size / (1024*1024)).toFixed(2)} MB.`, 'success');
                }
            } catch (err) {
                console.error('Compression failed', err);
                showFieldMessage(docNumber, 'Compression failed. Please compress under 5 MB and try again.', 'error');
                event.target.value = '';
                return;
            }
        }

        // Update file name display
        const fileNameSpan = document.getElementById(`file-name-${docNumber}`);
        fileNameSpan.textContent = fileToUpload.name || file.name;

        // Clear any previous error messages
        showFieldMessage(docNumber, '', 'success');

        if (autoUpload) {
            uploadFile(fileToUpload, docNumber);
        }
    }

    function uploadFile(file, docNumber) {
        // Get document name
        const docNameInput = document.getElementById(`doc-name-${docNumber}`);
        const documentName = docNameInput.value.trim();

        // Validate document name
        if (!documentName) {
            showFieldMessage(docNumber, 'Please enter a document name.', 'error');
            return;
        }

        const uploadBtn = document.getElementById(`upload-btn-${docNumber}`);

        // Disable upload button and show loading state
        if (uploadBtn) {
            uploadBtn.disabled = true;
            uploadBtn.innerHTML = '<div class="spinner"></div>Uploading...';
        }

        const formData = new FormData();
        formData.append('document', file);
        formData.append('document_name', documentName);

        // Show uploading state
        showFieldMessage(docNumber, '<div class="spinner"></div>Uploading...', 'info');

        fetch('{{ route("jobseeker.documents.upload") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            let data = null;
            try {
                data = await response.clone().json();
            } catch (e) {
                // Fall back to text for HTML responses
                data = { message: await response.text() };
            }

            if (response.ok && data?.success) {
                uploadedCount = data.uploaded_count;

                // Add to documents array
                currentDocuments.push(data.document);

                // Show success message at the top
                const successBox = document.getElementById('last-upload-success');
                const successText = document.getElementById('success-message-text');
                successText.textContent = `"${data.document.document_name}" uploaded successfully!`;
                successBox.classList.remove('hidden');

                // Update UI immediately
                updateProgress();
                renderUploadForms();
                renderDocumentsList();

                // Hide success message after 5 seconds
                setTimeout(() => {
                    successBox.classList.add('hidden');
                }, 5000);
            } else {
                const message = data?.message || 'Upload failed. Please try again.';
                showFieldMessage(docNumber, message, 'error');
                const uploadBtn = document.getElementById(`upload-btn-${docNumber}`);
                if (uploadBtn) {
                    uploadBtn.disabled = false;
                    uploadBtn.innerHTML = '<svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>Upload Document';
                }
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            showFieldMessage(docNumber, 'Upload failed. Please try again.', 'error');
            const uploadBtn = document.getElementById(`upload-btn-${docNumber}`);
            if (uploadBtn) {
                uploadBtn.disabled = false;
                uploadBtn.innerHTML = '<svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>Upload Document';
            }
        });
    }

    function showFieldMessage(docNumber, message, type) {
        const messageDiv = document.getElementById(`message-${docNumber}`);
        if (!messageDiv) return;

        const colors = {
            success: 'text-green-600',
            error: 'text-red-600',
            info: 'text-blue-600',
            warning: 'text-amber-600'
        };

        messageDiv.innerHTML = `<p class="text-sm ${colors[type] || 'text-gray-600'}">${message}</p>`;
    }

    async function compressPdf(file, maxBytes) {
        if (!window.PDFLib) {
            return file;
        }

        const arrayBuffer = await file.arrayBuffer();
        const srcDoc = await PDFLib.PDFDocument.load(arrayBuffer);
        const newDoc = await PDFLib.PDFDocument.create();
        const copiedPages = await newDoc.copyPages(srcDoc, srcDoc.getPageIndices());
        copiedPages.forEach(page => newDoc.addPage(page));

        const compressedBytes = await newDoc.save({ useObjectStreams: true });
        const compressedFile = new File([compressedBytes], (file.name.replace(/\.pdf$/i, '') || 'document') + '-compressed.pdf', { type: 'application/pdf' });

        // Return compressed version only if smaller
        if (compressedFile.size < file.size) {
            return compressedFile;
        }
        return file;
    }

    function renderDocumentsList() {
        if (currentDocuments.length === 0) {
            noDocumentsMessage.style.display = 'block';
            return;
        }

        noDocumentsMessage.style.display = 'none';

        documentsList.innerHTML = currentDocuments.map(doc => `
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-center flex-1">
                    <svg class="w-8 h-8 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">${doc.document_name || 'Document #' + doc.document_number}</p>
                        <p class="text-sm text-gray-500">${doc.original_name}</p>
                        <p class="text-xs text-gray-400">${doc.file_size_formatted} • Uploaded ${doc.uploaded_at}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ url('jobseeker/documents') }}/${doc.id}/download"
                       class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download
                    </a>
                    <button onclick="deleteDocument(${doc.id})"
                            class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        `).join('');
    }

    window.deleteDocument = function(documentId) {
        if (!confirm('Are you sure you want to delete this document?')) {
            return;
        }

        fetch(`{{ url('jobseeker/documents') }}/${documentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                loadStatus();
            } else {
                showNotification('Failed to delete document', 'error');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            showNotification('Failed to delete document', 'error');
        });
    };

    function showNotification(message, type) {
        alert(message);
    }
});
</script>
@endsection
