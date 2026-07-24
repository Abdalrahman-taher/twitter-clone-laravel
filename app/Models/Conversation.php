<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    // =====================================================
    // Conversation Participants
    // Users that belong to this conversation
    // =====================================================
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    // =====================================================
    // Conversation Messages
    // Messages inside this conversation
    // =====================================================
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
