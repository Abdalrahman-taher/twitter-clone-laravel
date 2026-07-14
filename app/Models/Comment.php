<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'body',
        'user_id',
        'tweet_id',
    ];


    // The user who wrote this comment
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    // The tweet this comment belongs to
    public function tweet(): BelongsTo
    {
        return $this->belongsTo(Tweet::class);
    }
}
