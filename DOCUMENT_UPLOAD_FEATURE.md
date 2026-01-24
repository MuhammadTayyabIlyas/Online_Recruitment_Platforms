# Dynamic Document Upload System

## Overview
This feature provides a step-by-step document upload system where job seekers can upload up to 10 PDF documents. Each upload field appears progressively after the previous document is successfully uploaded.

## Features Implemented

### ✅ Job Seeker Features

#### 1. **Progressive Document Upload**
- Start with one visible upload field
- After successful upload, the field locks and shows success state
- Next upload field automatically becomes active
- Maximum 10 documents per user
- Clean, intuitive UI with real-time feedback

#### 2. **File Validation**
- **Frontend Validation:**
  - Only PDF files accepted
  - Maximum file size: 4 MB
  - Immediate feedback on invalid files
  - File type and size checked before upload

- **Backend Validation:**
  - MIME type verification (application/pdf only)
  - File size limit enforcement (4MB = 4096KB)
  - Sequential upload enforcement (cannot skip documents)
  - Duplicate document number prevention

#### 3. **User Experience**
- **Progress Indicator:**
  - Visual progress bar showing X/10 documents uploaded
  - Percentage-based progress display

- **Upload Status Messages:**
  - "Uploading..." with spinner during upload
  - "Uploaded successfully. Please upload your next document." on success
  - Clear error messages for failures

- **Document Management:**
  - View all uploaded documents
  - Download any uploaded document
  - Delete documents with confirmation
  - See file size, name, and upload date

#### 4. **Visual States**
- **Active Field:** Blue border, ready for upload
- **Locked Field:** Grayed out with success checkmark
- **Uploading:** Spinner animation
- **Success:** Green border with success message
- **Error:** Red border with error message

### ✅ Employer/Admin Features

#### 1. **View User Documents**
- Access via route: `/employer/user-documents/{userId}`
- See all documents uploaded by a specific job seeker
- Document list with:
  - Document number (1-10)
  - Original filename
  - File size
  - Upload date

#### 2. **Download Documents**
- Secure download with authentication
- Access control (employers/admins only)
- Original filename preserved

#### 3. **Document Summary**
- Total documents count
- Total size of all documents
- Latest upload timestamp
- Visual progress indicator

## Technical Implementation

### Database Schema

#### `user_documents` Table
```sql
- id (bigint, primary key)
- user_id (foreign key to users)
- document_number (integer, 1-10)
- file_name (string, UUID-based)
- file_path (string, storage path)
- original_name (string, user's filename)
- file_size (integer, bytes)
- mime_type (string, default: application/pdf)
- created_at (timestamp)
- updated_at (timestamp)
- UNIQUE(user_id, document_number)
```

### Models

#### `UserDocument` Model
- Location: `app/Models/UserDocument.php`
- Relationships:
  - `belongsTo(User::class)`
- Attributes:
  - `file_size_formatted` - Human-readable file size
  - `full_path` - Complete storage path

#### `User` Model Enhancement
- Added relationship: `hasMany(UserDocument::class)`
- Documents ordered by document_number

### Controllers

#### `JobSeeker/DocumentController`
Location: `app/Http/Controllers/JobSeeker/DocumentController.php`

**Methods:**
- `index()` - Display upload page
- `status()` - AJAX endpoint for current upload status
- `upload(Request)` - Handle file upload
- `download($id)` - Download user's own document
- `destroy($id)` - Delete document

**Security:**
- Authentication required
- Job seeker role verification
- User can only access their own documents

#### `Employer/UserDocumentController`
Location: `app/Http/Controllers/Employer/UserDocumentController.php`

**Methods:**
- `show($userId)` - View user's documents
- `download($documentId)` - Download user's document

**Security:**
- Authentication required
- Employer/Admin role verification
- Access control for sensitive documents

### Routes

#### Job Seeker Routes
```php
Route::prefix('jobseeker/documents')->name('jobseeker.documents.')->group(function () {
    Route::get('/', [DocumentController::class, 'index'])->name('index');
    Route::get('/status', [DocumentController::class, 'status'])->name('status');
    Route::post('/upload', [DocumentController::class, 'upload'])->name('upload');
    Route::get('/{id}/download', [DocumentController::class, 'download'])->name('download');
    Route::delete('/{id}', [DocumentController::class, 'destroy'])->name('destroy');
});
```

#### Employer Routes
```php
Route::prefix('employer/user-documents')->name('employer.user-documents.')->group(function () {
    Route::get('/{user}', [UserDocumentController::class, 'show'])->name('show');
    Route::get('/document/{documentId}/download', [UserDocumentController::class, 'download'])->name('download');
});
```

### Views

#### Job Seeker Upload Page
- Location: `resources/views/jobseeker/documents/index.blade.php`
- Features:
  - Dynamic form generation
  - Real-time progress tracking
  - AJAX file uploads
  - Responsive design
  - File validation
  - Status messages

#### Employer Document View
- Location: `resources/views/employer/user-documents/show.blade.php`
- Features:
  - Document listing
  - Download buttons
  - Document statistics
  - Responsive layout

### Navigation

#### Job Seeker Dashboard
- Added "My Documents" link in sidebar
- Location: `resources/views/layouts/dashboard.blade.php`
- Icon: Document/file icon
- Route highlighting when active

## File Storage

### Storage Structure
```
storage/app/
└── user_documents/
    └── {user_id}/
        ├── {uuid-1}.pdf
        ├── {uuid-2}.pdf
        └── ...
```

### File Naming
- Files stored with UUID names for security
- Original names preserved in database
- Download uses original filename

## Security Features

### 1. **Authentication & Authorization**
- All routes require authentication
- Role-based access control
- Users can only access their own documents
- Employers/Admins verified before document access

### 2. **File Validation**
- MIME type verification
- File size limits
- Extension whitelist (.pdf only)
- Sequential upload enforcement

### 3. **Secure Downloads**
- No direct file URLs
- Download through controller
- Access verification
- Served through Laravel Storage facade

### 4. **CSRF Protection**
- All POST/PUT/DELETE requests CSRF protected
- Token verification on uploads

## API Endpoints

### Get Upload Status (AJAX)
```
GET /jobseeker/documents/status
Response: {
  "uploaded_count": 3,
  "next_document_number": 4,
  "can_upload_more": true,
  "documents": [...]
}
```

### Upload Document (AJAX)
```
POST /jobseeker/documents/upload
Body: FormData {
  document: File,
  document_number: Integer
}
Response: {
  "success": true,
  "message": "Uploaded successfully...",
  "document": {...},
  "uploaded_count": 4,
  "can_upload_more": true
}
```

### Delete Document (AJAX)
```
DELETE /jobseeker/documents/{id}
Response: {
  "success": true,
  "message": "Document deleted successfully."
}
```

## Usage Instructions

### For Job Seekers

1. **Navigate to My Documents**
   - Click "My Documents" in the sidebar
   - Or visit: `/jobseeker/documents`

2. **Upload First Document**
   - Click "Choose PDF File" on Document #1
   - Select a PDF file (max 4 MB)
   - File uploads automatically
   - Wait for success message

3. **Upload Next Documents**
   - Document #2 becomes active after #1 success
   - Continue uploading sequentially
   - Maximum 10 documents

4. **Manage Documents**
   - View all uploaded documents below
   - Download any document
   - Delete documents (with confirmation)

### For Employers/Admins

1. **View Candidate Documents**
   - Navigate to candidate profile
   - Click "View Documents" link
   - Or visit: `/employer/user-documents/{userId}`

2. **Download Documents**
   - Click download button next to any document
   - File downloads with original name

## Notes About PDF Compression

**Client-side PDF compression** was considered but **not implemented** for the following reasons:

1. **Complexity**: PDF compression in browser is computationally expensive
2. **Reliability**: May not work for all PDF types
3. **Quality Loss**: Compression can degrade document quality
4. **Better Approach**: Users should prepare documents before upload

**Recommendation**: If file size is an issue:
- Use PDF optimization tools before upload
- Reduce image quality in PDFs
- Remove unnecessary pages
- Use tools like Adobe Acrobat or online PDF compressors

## Future Enhancements (Optional)

1. **Document Types**
   - Allow categorization (Resume, Certificate, ID, etc.)
   - Custom labels for each document

2. **Bulk Upload**
   - Upload multiple files at once (after completing feature)
   - Drag and drop interface

3. **Preview**
   - In-browser PDF preview
   - Thumbnail generation

4. **Notifications**
   - Email notification when documents uploaded
   - Admin alerts for new documents

5. **Document Verification**
   - Admin approval workflow
   - Status tracking (pending, approved, rejected)

6. **Export**
   - Bulk download as ZIP
   - Document sharing via secure links

## Troubleshooting

### Common Issues

1. **Upload Fails**
   - Check file size (must be ≤ 4 MB)
   - Verify file type (must be PDF)
   - Check internet connection
   - Verify sequential order

2. **Cannot See Documents**
   - Clear browser cache
   - Check authentication
   - Verify role permissions

3. **Download Issues**
   - Check file still exists in storage
   - Verify permissions
   - Check storage disk space

### Error Messages

- **"Maximum 10 documents allowed"** - You've reached the limit
- **"Please upload document #X next"** - Upload in sequential order
- **"Please upload a PDF file only"** - Wrong file type
- **"File size exceeds 4 MB"** - File too large
- **"File not found"** - Document deleted or missing

## Testing Checklist

- [ ] Upload first document successfully
- [ ] Second field appears after first upload
- [ ] Cannot upload out of sequence
- [ ] File type validation works
- [ ] File size validation works
- [ ] Progress bar updates correctly
- [ ] Download works for job seeker
- [ ] Download works for employer
- [ ] Delete works with confirmation
- [ ] Maximum 10 documents enforced
- [ ] Navigation link appears and works
- [ ] Mobile responsive
- [ ] Error messages display correctly
- [ ] Success messages display correctly

## Files Modified/Created

### Created Files:
1. `database/migrations/2025_12_13_115316_create_user_documents_table.php`
2. `app/Models/UserDocument.php`
3. `app/Http/Controllers/JobSeeker/DocumentController.php`
4. `app/Http/Controllers/Employer/UserDocumentController.php`
5. `resources/views/jobseeker/documents/index.blade.php`
6. `resources/views/employer/user-documents/show.blade.php`

### Modified Files:
1. `app/Models/User.php` - Added documents relationship
2. `routes/web.php` - Added document routes
3. `resources/views/layouts/dashboard.blade.php` - Added navigation link

## Database Migration

Run the migration:
```bash
php artisan migrate
```

Or if in production:
```bash
php artisan migrate --force
```

## Conclusion

The dynamic document upload system is fully implemented and ready for use. It provides a professional, user-friendly experience for job seekers to upload their documents and for employers to view and download them securely.
