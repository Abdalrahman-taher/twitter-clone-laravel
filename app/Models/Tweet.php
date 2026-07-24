<?php

namespace App\Models;

use App\Models\Retweet;
use App\Traits\HasMedias;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tweet extends Model
{
    use HasMedias;

    // Allow these fields to be saved
    protected $fillable = [
        'body',
        'user_id',
        'parent_id',
        'collection',
        'path',
        'mime_type',
        'size',
    ];

    // =====================================================
    // Every tweet belongs to one user
    // =====================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =====================================================
    // One tweet can be liked by many users
    // =====================================================

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    // One tweet can be retweeted by many users
    public function retweets(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'retweets');
    }

    // =====================================================
    // Check if a specific user liked this tweet
    // =====================================================

    public function isLikedBy(User $user): bool
    {
        return $this->likes->contains($user);
    }

    // =====================================================
    // Check if a specific user retweeted this tweet
    // =====================================================

    public function isRetweetedBy(User $user): bool
    {
        return Retweet::where('user_id', $user->id)
            ->where('tweet_id', $this->id)
            ->exists();
    }

    // =====================================================
    // Check if a specific user bookmarked this tweet
    // =====================================================

    public function isBookmarkedBy(User $user): bool
    {
        return $this->bookmarks->contains($user);
    }

    // =====================================================
    // Parent Tweet
    // =====================================================

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Tweet::class, 'parent_id');
    }

    // =====================================================
    // Comments
    // =====================================================

    public function comments(): HasMany
    {
        return $this->hasMany(Tweet::class, 'parent_id');
    }

    // =====================================================
    // Tweet Bookmarks Relationship
    // One tweet can be bookmarked by many users
    // =====================================================

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }
}
