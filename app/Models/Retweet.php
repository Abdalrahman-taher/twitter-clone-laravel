<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Retweet extends Model
{
    // Allow mass assignment
    protected $fillable = [
        'user_id',
        'tweet_id',
    ];

    // =====================================================
    // The user who made the retweet
    // =====================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =====================================================
    // The original tweet
    // =====================================================

    public function tweet(): BelongsTo
    {
        return $this->belongsTo(Tweet::class);
    }
}
