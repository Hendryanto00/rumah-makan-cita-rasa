<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin bisa melihat semua review, user biasa hanya review mereka sendiri
        return $user->role && $user->role->name === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Review $review): bool
    {
        // User bisa melihat review mereka sendiri atau semua review (karena tidak ada status)
        return $user->id === $review->user_id || true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // User yang sudah login bisa membuat review
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Review $review): bool
    {
        // User bisa update review mereka sendiri
        return $user->id === $review->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): bool
    {
        // User bisa hapus review mereka sendiri, admin bisa hapus semua
        return $user->id === $review->user_id || 
               ($user->role && $user->role->name === 'admin');
    }

    /**
     * Determine whether the user can moderate reviews (approve, hide).
     */
    public function moderate(User $user): bool
    {
        // Hanya admin yang bisa moderasi
        return $user->role && $user->role->name === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Review $review): bool
    {
        return $user->role && $user->role->name === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Review $review): bool
    {
        return $user->role && $user->role->name === 'admin';
    }
}
