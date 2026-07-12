<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Tweet extends Model
{
    // Allow these fields to be saved
    protected $fillable = [
        'body',
        'user_id',
//        'image'=> 'array',
//        'video',
    ];


    // One tweet can have many media files
    // (images and videos)
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }


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
