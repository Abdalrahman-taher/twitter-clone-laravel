<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('conversation.{conversation}', function (
    User $user,
    int $conversation
) {
    return $user->conversations()
        ->where('conversations.id', $conversation)
        ->exists();
});
