<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tweet extends Model
{
    // Allow these fields to be saved
    protected $fillable = [
        'body',
        'user_id',
    ];

    // Every tweet belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
