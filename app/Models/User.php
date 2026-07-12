<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Tweet;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;


#[Fillable([
    'name',
    'email',
    'password',
    'avatar',
    'cover',
    'username',
    'bio',
    'location',
    'website',
])]

#[Hidden(['password', 'remember_token'])]


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];

    }

    // One user can have many tweets
    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class);
    }

    // One user can like many tweets
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Tweet::class, 'likes');
    }


    // One user can have many media files
    // (avatar, cover, and any future media)
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

}


