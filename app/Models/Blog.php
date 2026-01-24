<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Enums\BlogStatus;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'user_id',
        'blog_category_id',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'admin_feedback',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
        'published_at',
        'views_count',
        'is_featured',
        'featured_order',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'status' => BlogStatus::class,
    ];

    protected $appends = ['reading_time'];

    /**
     * Boot method.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            $blog->uuid = $blog->uuid ?? Str::uuid();
            $blog->slug = $blog->slug ?? Str::slug($blog->title) . '-' . Str::random(6);

            // Auto-generate excerpt if not provided
            if (!$blog->excerpt && $blog->content) {
                $blog->excerpt = Str::limit(strip_tags($blog->content), 200);
            }

            // Auto-generate meta_title if not provided
            if (!$blog->meta_title) {
                $blog->meta_title = $blog->title;
            }

            // Auto-generate meta_description if not provided
            if (!$blog->meta_description && $blog->excerpt) {
                $blog->meta_description = Str::limit($blog->excerpt, 160);
            }
        });

        static::updating(function ($blog) {
            // Regenerate slug if title changed (only for drafts)
            if ($blog->isDirty('title') && $blog->status === BlogStatus::DRAFT && !$blog->isDirty('slug')) {
                $blog->slug = Str::slug($blog->title) . '-' . Str::random(6);
            }
        });
    }

    /**
     * Get the author of the blog.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category of the blog.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Get the admin who reviewed the blog.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get all views for the blog.
     */
    public function views(): HasMany
    {
        return $this->hasMany(BlogView::class);
    }

    /**
     * Get all attachments for the blog.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(BlogAttachment::class);
    }

    /**
     * Scope to get only approved blogs.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', BlogStatus::APPROVED);
    }

    /**
     * Scope to get only published blogs (approved and published).
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->approved()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope to get featured blogs.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)
            ->orderBy('featured_order')
            ->orderByDesc('published_at');
    }

    /**
     * Scope to get pending blogs.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', BlogStatus::PENDING);
    }

    /**
     * Scope to get draft blogs.
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', BlogStatus::DRAFT);
    }

    /**
     * Scope to get rejected blogs.
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', BlogStatus::REJECTED);
    }

    /**
     * Scope to filter by author.
     */
    public function scopeByAuthor(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by category.
     */
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('blog_category_id', $categoryId);
    }

    /**
     * Scope to search blogs.
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to get popular blogs.
     */
    public function scopePopular(Builder $query, int $limit = 5): Builder
    {
        return $query->published()
            ->orderByDesc('views_count')
            ->limit($limit);
    }

    /**
     * Scope to get recent blogs.
     */
    public function scopeRecent(Builder $query, int $limit = 5): Builder
    {
        return $query->published()
            ->orderByDesc('published_at')
            ->limit($limit);
    }

    /**
     * Get the route key name for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get estimated reading time in minutes.
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, (int)ceil($wordCount / 200));
    }

    /**
     * Get the featured image URL.
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (!$this->featured_image) {
            return null;
        }

        return asset('storage/' . $this->featured_image);
    }

    /**
     * Check if blog can be edited.
     */
    public function canBeEdited(): bool
    {
        return in_array($this->status, [BlogStatus::DRAFT, BlogStatus::REJECTED]);
    }

    /**
     * Check if blog can be submitted for review.
     */
    public function canBeSubmitted(): bool
    {
        return $this->status === BlogStatus::DRAFT;
    }

    /**
     * Check if blog can be withdrawn from review.
     */
    public function canBeWithdrawn(): bool
    {
        return $this->status === BlogStatus::PENDING;
    }

    /**
     * Increment the views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Get related blogs from the same category.
     */
    public function relatedBlogs(int $limit = 3)
    {
        return static::published()
            ->where('id', '!=', $this->id)
            ->where('blog_category_id', $this->blog_category_id)
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }
}
