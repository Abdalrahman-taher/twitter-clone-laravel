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
use App\Traits\HasMedias;

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
    use HasFactory, Notifiable, HasMedias;

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

    // =====================================================
    // User Tweets Relationship
    // One user can create many tweets
    // =====================================================
    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class);
    }

    // =====================================================
    // User Likes Relationship
    // One user can like many tweets
    // =====================================================
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Tweet::class, 'likes');
    }

    // =====================================================
    // Following Relationship
    // Users that the current user is following
    // =====================================================
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'followers',
            'follower_id',
            'following_id'
        );
    }

    // =====================================================
    // Followers Relationship
    // Users that are following the current user
    // =====================================================
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'followers',
            'following_id',
            'follower_id'
        );
    }

    // =====================================================
    // Check Following Status
    // Determine if the current user follows another user
    // =====================================================
    public function isFollowing(User $user): bool
    {
        return $this->following()
            ->where('following_id', $user->id)
            ->exists();
    }

    // =====================================================
    // Follow User
    // Create a follow relationship if it does not already exist
    // =====================================================
    public function follow(User $user): void
    {
        // Prevent following yourself
        if ($this->id === $user->id) {
            return;
        }

        // Prevent duplicate follow records
        $this->following()->syncWithoutDetaching($user->id);
    }

    // =====================================================
    // Unfollow User
    // Remove the follow relationship
    // =====================================================
    public function unfollow(User $user): void
    {
        $this->following()->detach($user->id);
    }
}
