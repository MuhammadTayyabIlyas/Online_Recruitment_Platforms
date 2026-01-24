<?php

namespace App\Http\Controllers\ContentCreator;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogAttachment;
use App\Enums\BlogStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:employer,educational_institution,admin');
    }

    /**
     * Display a listing of the user's blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::byAuthor(auth()->id())->with('category');

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $blogs = $query->latest()->paginate(10)->withQueryString();

        // Statistics for dashboard
        $stats = [
            'total' => Blog::byAuthor(auth()->id())->count(),
            'draft' => Blog::byAuthor(auth()->id())->where('status', BlogStatus::DRAFT)->count(),
            'pending' => Blog::byAuthor(auth()->id())->where('status', BlogStatus::PENDING)->count(),
            'approved' => Blog::byAuthor(auth()->id())->where('status', BlogStatus::APPROVED)->count(),
            'rejected' => Blog::byAuthor(auth()->id())->where('status', BlogStatus::REJECTED)->count(),
        ];

        return view('content-creator.blogs.index', compact('blogs', 'stats'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        $this->authorize('create', Blog::class);
        $categories = BlogCategory::active()->ordered()->get();
        return view('content-creator.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created blog.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Blog::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string|min:100',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'featured_image_alt' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->handleFeaturedImageUpload($request->file('featured_image'));
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = BlogStatus::DRAFT;

        $blog = Blog::create($validated);

        return redirect()->route('content-creator.blogs.show', $blog)
            ->with('success', 'Blog created successfully as draft.');
    }

    /**
     * Display the specified blog.
     */
    public function show(Blog $blog)
    {
        $this->authorize('view', $blog);
        $blog->load('category', 'reviewer');
        return view('content-creator.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);
        $categories = BlogCategory::active()->ordered()->get();
        return view('content-creator.blogs.edit', compact('blog', 'categories'));
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
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'featured_image_alt' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $validated['featured_image'] = $this->handleFeaturedImageUpload($request->file('featured_image'));
        }

        $blog->update($validated);

        return redirect()->route('content-creator.blogs.show', $blog)
            ->with('success', 'Blog updated successfully.');
    }

    /**
     * Submit the blog for review.
     */
    public function submit(Blog $blog)
    {
        $this->authorize('submit', $blog);

        $blog->update([
            'status' => BlogStatus::PENDING,
            'submitted_at' => now(),
            'admin_feedback' => null,
        ]);

        return back()->with('success', 'Blog submitted for review successfully.');
    }

    /**
     * Withdraw the blog from review.
     */
    public function withdraw(Blog $blog)
    {
        $this->authorize('withdraw', $blog);

        $blog->update([
            'status' => BlogStatus::DRAFT,
            'submitted_at' => null,
        ]);

        return back()->with('success', 'Blog withdrawn from review.');
    }

    /**
     * Remove the specified blog.
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        // Delete featured image
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('content-creator.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    /**
     * Upload Trix editor images (AJAX endpoint).
     */
    public function uploadAttachment(Request $request)
    {
        $request->validate([
            'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $file = $request->file('attachment');

        // Generate unique filename
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = 'blogs/attachments/' . date('Y/m');

        // Compress and store image
        $image = Image::read($file);
        $image->scale(width: 1200); // Max width 1200px

        $fullPath = $path . '/' . $filename;
        Storage::disk('public')->put($fullPath, $image->encode());

        // Return URL for Trix editor
        return response()->json([
            'url' => asset('storage/' . $fullPath),
            'path' => $fullPath,
        ]);
    }

    /**
     * Handle featured image upload with compression.
     */
    private function handleFeaturedImageUpload($file): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = 'blogs/featured/' . date('Y/m');

        // Compress image (16:9 aspect ratio, max width 1920px)
        $image = Image::read($file);
        $image->cover(1920, 1080); // 16:9 ratio

        $fullPath = $path . '/' . $filename;
        Storage::disk('public')->put($fullPath, $image->encode());

        return $fullPath;
    }
}
