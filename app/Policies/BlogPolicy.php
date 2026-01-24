<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use App\Enums\BlogStatus;

class BlogPolicy
{
    /**
     * Determine if the user can view any blogs (in their dashboard).
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['employer', 'educational_institution', 'admin']);
    }

    /**
     * Determine if the user can view the blog.
     */
    public function view(User $user, Blog $blog): bool
    {
        // Admin can view all
        if ($user->hasRole('admin')) {
            return true;
        }

        // Author can view their own
        return $user->id === $blog->user_id;
    }

    /**
     * Determine if the user can create blogs.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['employer', 'educational_institution']);
    }

    /**
     * Determine if the user can update the blog.
     */
    public function update(User $user, Blog $blog): bool
    {
        // Admin can update any
        if ($user->hasRole('admin')) {
            return true;
        }

        // Author can only update their own draft or rejected blogs
        return $user->id === $blog->user_id && $blog->canBeEdited();
    }

    /**
     * Determine if the user can delete the blog.
     */
    public function delete(User $user, Blog $blog): bool
    {
        // Admin can delete any
        if ($user->hasRole('admin')) {
            return true;
        }

        // Author can only delete draft blogs
        return $user->id === $blog->user_id && $blog->status === BlogStatus::DRAFT;
    }

    /**
     * Determine if the user can submit the blog for review.
     */
    public function submit(User $user, Blog $blog): bool
    {
        return $user->id === $blog->user_id && $blog->canBeSubmitted();
    }

    /**
     * Determine if the user can withdraw the blog from review.
     */
    public function withdraw(User $user, Blog $blog): bool
    {
        return $user->id === $blog->user_id && $blog->canBeWithdrawn();
    }

    /**
     * Determine if the user can approve/reject blogs.
     */
    public function review(User $user, Blog $blog): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can feature blogs.
     */
    public function feature(User $user, Blog $blog): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can restore soft-deleted blogs.
     */
    public function restore(User $user, Blog $blog): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can permanently delete the blog.
     */
    public function forceDelete(User $user, Blog $blog): bool
    {
        return $user->hasRole('admin');
    }
}
