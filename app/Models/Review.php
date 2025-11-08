<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'menu_id',
        'rating',
        'comment',
        'status'
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Menu
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    // Method untuk check apakah review bisa diedit oleh user
    public function canBeEditedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    // Method untuk check apakah review bisa dihapus oleh user
    public function canBeDeletedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }
}
