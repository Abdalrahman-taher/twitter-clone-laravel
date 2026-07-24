<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Media;

class ProfileController extends Controller
{
    /**
     * Display a user's public profile page.
     */
    public function show(User $user): View
    {

        $tab = request('tab', 'posts');

        // =====================================================
        // Load User Relations
        // Load profile media, tweet media and follow counts
        // =====================================================

        $user->load([
            'medias',
        ])->loadCount([
            'followers',
            'following',
        ]);

        // =====================================================
        // Check Follow Status
        // Determine if the authenticated user follows this profile
        // =====================================================

        $isFollowing = false;

        if (auth()->check()) {
            $isFollowing = auth()->user()->isFollowing($user);
        }

        // =====================================================
        // Get User Tweets
        // Load tweets with media, likes, comments and retweets
        // =====================================================

        $query = $user->tweets()
            ->with([
                'medias',
                'user.medias',
                'likes',
                'comments.user.medias',
            ])
            ->withCount([
                'likes',
                'comments',
                'retweets',
            ])
            ->latest();

        switch ($tab) {

            case 'replies':
                $query->whereNotNull('parent_id');
                break;

            case 'media':
                $query->whereHas('medias');
                break;

            case 'likes':

                $query = $user->likes()
                    ->with([
                        'medias',
                        'user.medias',
                        'likes',
                        'comments.user.medias',
                    ])
                    ->withCount([
                        'likes',
                        'comments',
                        'retweets',
                    ])
                    ->latest();

                break;

            default:
                $query->whereNull('parent_id');
                break;
        }

        $tweets = $query->get();


        return view('profile.show', [
            'user' => $user,
            'tweets' => $tweets,
            'isFollowing' => $isFollowing,
            'tab' => $tab,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Get the validated text fields (name, username, bio, location, website)
        $data = $request->validated();

        // Avatar and cover are files, so we save them separately below
        unset($data['avatar'], $data['cover']);

        $request->user()->fill($data);

        // =====================================================
        // Upload User Avatar
        // Save avatar as media record
        // =====================================================
        if ($request->hasFile('avatar')) {

            $path = $request->file('avatar')->store('avatars', 'public');

            $request->user()->medias()->create([
                'collection' => 'avatar',
                'path' => $path,
                'mime_type' => $request->file('avatar')->getMimeType(),
                'size' => $request->file('avatar')->getSize(),
            ]);
        }
        // =====================================================
        // Upload User Cover
        // Save cover as media record
        // =====================================================

        if ($request->hasFile('cover')) {

            $path = $request->file('cover')->store('covers', 'public');

            $request->user()->medias()->create([
                'collection' => 'cover',
                'path' => $path,
                'mime_type' => $request->file('cover')->getMimeType(),
                'size' => $request->file('cover')->getSize(),
            ]);
        }
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
