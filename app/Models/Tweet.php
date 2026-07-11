<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tweet extends Model
{
    // Allow these fields to be saved
    protected $fillable = [
        'body',
        'user_id',
        'image',
        'video',
    ];

    // Every tweet belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // One tweet can be liked by many users
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    // =====================================================
    // Check if a specific user liked this tweet
    // Returns:
    // true  => user liked the tweet
    // false => user didn't like the tweet
    public function isLikedBy(User $user): bool
    {
        return $this->likes->contains($user);
    }
}
