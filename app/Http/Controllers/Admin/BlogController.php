<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Enums\BlogStatus;
use App\Notifications\BlogApprovedNotification;
use App\Notifications\BlogRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'category'])->withTrashed();

        // Search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'trashed') {
                $query->onlyTrashed();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Category filter
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Author filter
        if ($request->filled('author')) {
            $query->byAuthor($request->author);
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        $blogs = $query->latest()->paginate(20)->withQueryString();
        $categories = BlogCategory::active()->ordered()->get();
        $authors = User::whereHas('blogs')->get();

        // Statistics
        $stats = [
            'total' => Blog::count(),
            'pending' => Blog::where('status', BlogStatus::PENDING)->count(),
            'approved' => Blog::where('status', BlogStatus::APPROVED)->count(),
            'rejected' => Blog::where('status', BlogStatus::REJECTED)->count(),
            'draft' => Blog::where('status', BlogStatus::DRAFT)->count(),
            'featured' => Blog::where('is_featured', true)->count(),
        ];

        return view('admin.blogs.index', compact('blogs', 'categories', 'authors', 'stats'));
    }

    /**
     * Display the specified blog.
     */
    public function show(Blog $blog)
    {
        $blog->load(['author', 'category', 'reviewer', 'attachments']);
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);
        $categories = BlogCategory::active()->ordered()->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string|min:100',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'featured_image_alt' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'featured_order' => 'nullable|integer|min:0',
        ]);

        $blog->update($validated);

        return redirect()->route('admin.blogs.show', $blog)
            ->with('success', 'Blog updated successfully.');
    }

    /**
     * Update the blog status (approve/reject).
     */
    public function updateStatus(Request $request, Blog $blog)
    {
        $this->authorize('review', $blog);

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,pending,draft',
            'admin_feedback' => 'nullable|string|max:2000',
        ]);

        $blog->update([
            'status' => $validated['status'],
            'admin_feedback' => $validated['admin_feedback'] ?? null,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
            'published_at' => $validated['status'] === 'approved' ? now() : null,
        ]);

        // Send notification to author
        if ($validated['status'] === 'approved') {
            $blog->author->notify(new BlogApprovedNotification($blog));
        } elseif ($validated['status'] === 'rejected') {
            $blog->author->notify(new BlogRejectedNotification($blog));
        }

        return back()->with('success', 'Blog status updated to ' . $validated['status'] . '.');
    }

    /**
     * Toggle featured status of the blog.
     */
    public function toggleFeatured(Blog $blog)
    {
        $this->authorize('feature', $blog);

        $blog->update([
            'is_featured' => !$blog->is_featured,
            'featured_order' => !$blog->is_featured ? 0 : $blog->featured_order,
        ]);

        $status = $blog->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Blog marked as {$status}.");
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        if ($blog->trashed()) {
            // Permanently delete
            // Delete featured image
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            // Delete attachments (handled by model event)
            $blog->forceDelete();

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog permanently deleted.');
        }

        // Soft delete
        $blog->delete();
        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog moved to trash.');
    }

    /**
     * Restore a soft-deleted blog.
     */
    public function restore($id)
    {
        $blog = Blog::withTrashed()->findOrFail($id);
        $this->authorize('restore', $blog);

        $blog->restore();
        return back()->with('success', 'Blog restored successfully.');
    }

    /**
     * Perform bulk actions on blogs.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,restore,feature,unfeature,approve,reject',
            'blogs' => 'required|array',
            'blogs.*' => 'exists:blogs,id',
        ]);

        $blogs = Blog::withTrashed()->whereIn('id', $validated['blogs']);

        switch ($validated['action']) {
            case 'delete':
                $blogs->get()->each->delete();
                $message = 'Selected blogs moved to trash.';
                break;
            case 'restore':
                $blogs->onlyTrashed()->get()->each->restore();
                $message = 'Selected blogs restored.';
                break;
            case 'feature':
                $blogs->update(['is_featured' => true]);
                $message = 'Selected blogs marked as featured.';
                break;
            case 'unfeature':
                $blogs->update(['is_featured' => false]);
                $message = 'Selected blogs unmarked as featured.';
                break;
            case 'approve':
                $blogs->update([
                    'status' => BlogStatus::APPROVED,
                    'reviewed_at' => now(),
                    'reviewed_by' => auth()->id(),
                    'published_at' => now(),
                ]);
                $message = 'Selected blogs approved.';
                break;
            case 'reject':
                $blogs->update([
                    'status' => BlogStatus::REJECTED,
                    'reviewed_at' => now(),
                    'reviewed_by' => auth()->id(),
                ]);
                $message = 'Selected blogs rejected.';
                break;
        }

        return back()->with('success', $message);
    }
}
