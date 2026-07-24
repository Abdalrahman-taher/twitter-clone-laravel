<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\MorphMany;


#[Fillable([
    'conversation_id',
    'sender_id',
    'body',
])]
class Message extends Model
{
    // =====================================================
    // Conversation
    // Message belongs to a conversation
    // =====================================================
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    // =====================================================
    // Sender
    // User who sent this message
    // =====================================================
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }


    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
