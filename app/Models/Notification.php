<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    // =====================================================
    // Mass Assignable Attributes
    // =====================================================

    protected $fillable = [
        'user_id',
        'actor_id',
        'tweet_id',
        'type',
        'is_read',
    ];

    // =====================================================
    // Notification Owner
    // User who receives the notification
    // =====================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =====================================================
    // Notification Actor
    // User who performed the action
    // =====================================================

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    // =====================================================
    // Related Tweet
    // Tweet associated with the notification
    // =====================================================

    public function tweet(): BelongsTo
    {
        return $this->belongsTo(Tweet::class);
    }
}
