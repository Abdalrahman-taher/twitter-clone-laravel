<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{

    protected $fillable = [
        'user_id',
        'content',
        'read_at',
    ];

    protected $casts = [
        'content' => 'array',
        'read_at' => 'datetime',
    ];

    // Notification Owner

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =====================================================
    // Create Notification

    public static function send(int $userId, array $content): void
    {
        $actor = auth()->user();
        $actorAvatar = null;

        if ($actor) {
            $actorAvatar = $actor->medias
                ->where('collection', 'avatar')
                ->first();
        }

        self::create([
            'user_id' => $userId,
            'content' => array_merge($content, [
                'actor' => [
                    'id' => $actor?->id,
                    'name' => $actor?->name,
                    'username' => $actor?->username,
                    'avatar' => $actorAvatar?->path,
                ],
            ]),
            'read_at' => null,
        ]);
    }
}
