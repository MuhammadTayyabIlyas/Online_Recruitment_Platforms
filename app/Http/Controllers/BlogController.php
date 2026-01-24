<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogView;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of published blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::published()->with(['author', 'category']);

        $selectedCategory = null;

        // Category filter
        if ($request->filled('category')) {
            $selectedCategory = BlogCategory::where('slug', $request->category)->firstOrFail();
            $query->byCategory($selectedCategory->id);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderByDesc('views_count');
                break;
            case 'oldest':
                $query->orderBy('published_at');
                break;
            case 'latest':
            default:
                $query->orderByDesc('published_at');
                break;
        }

        $blogs = $query->paginate(12)->withQueryString();

        $categories = BlogCategory::active()
            ->withCount('approvedBlogs')
            ->ordered()
            ->get();

        // Rename approved_blogs_count to blogs_count for each category
        $categories->each(function ($category) {
            $category->blogs_count = $category->approved_blogs_count;
        });

        $featuredBlogs = Blog::featured()->published()->limit(3)->get();

        $popularBlogs = Blog::popular(5)->get();

        $totalBlogs = Blog::published()->count();

        return view('blogs.index', compact('blogs', 'categories', 'featuredBlogs', 'popularBlogs', 'totalBlogs', 'selectedCategory'));
    }

    /**
     * Display the specified blog.
     */
    public function show(Request $request, Blog $blog)
    {
        // Only show approved blogs to public
        if ($blog->status !== \App\Enums\BlogStatus::APPROVED) {
            abort(404);
        }

        $blog->load(['author', 'category', 'attachments']);
        $blog->author->loadCount('blogs');

        // Track view (unique by IP within 24 hours)
        $this->trackView($blog, $request);

        // Get related blogs
        $relatedBlogs = $blog->relatedBlogs(3);

        // SEO meta data
        $metaTitle = $blog->meta_title ?? $blog->title;
        $metaDescription = $blog->meta_description ?? $blog->excerpt;
        $metaKeywords = $blog->meta_keywords;

        return view('blogs.show', compact('blog', 'relatedBlogs', 'metaTitle', 'metaDescription', 'metaKeywords'));
    }

    /**
     * Display blogs by category.
     */
    public function byCategory(BlogCategory $category)
    {
        $blogs = Blog::published()
            ->byCategory($category->id)
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(12);

        $categories = BlogCategory::active()
            ->withCount('approvedBlogs')
            ->ordered()
            ->get();

        // Rename approved_blogs_count to blogs_count for each category
        $categories->each(function ($cat) {
            $cat->blogs_count = $cat->approved_blogs_count;
        });

        return view('blogs.category', compact('blogs', 'category', 'categories'));
    }

    /**
     * Track blog view (unique per IP per 24 hours).
     */
    private function trackView(Blog $blog, Request $request): void
    {
        $ip = $request->ip();
        $userId = auth()->id();

        // Check if view already exists within last 24 hours
        $existingView = BlogView::where('blog_id', $blog->id)
            ->where('ip_address', $ip)
            ->where('viewed_at', '>', now()->subDay())
            ->exists();

        if (!$existingView) {
            BlogView::create([
                'blog_id' => $blog->id,
                'user_id' => $userId,
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
                'viewed_at' => now(),
            ]);

            $blog->incrementViews();
        }
    }
}
