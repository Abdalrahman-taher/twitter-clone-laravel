<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Traits\HandlesMediaUploads;
use App\Models\Notification;


class TweetController extends Controller
{
    use HandlesMediaUploads;

    public function store(Request $request)
    {
        // =====================================================
        // Validate Tweet Data
        // Check tweet text, images and videos before saving
        // =====================================================

        $request->validate([
            'body' => 'required|max:280',

            // Validate uploaded images
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',

            // Validate uploaded videos
            'videos' => 'nullable|array',
            'videos.*' => 'mimes:mp4|max:51200',
        ]);

        // =====================================================
        // Save Tweet
        // Create a new tweet for the logged-in user
        // =====================================================

        $tweet = auth()->user()->tweets()->create([
            'body' => $request->body,
        ]);

        // =====================================================
        // Upload Tweet Media
        // =====================================================

        $this->uploadMedia($request, $tweet);

        // =====================================================
        // Return Back
        // Go back to home page
        // =====================================================

        return redirect()->back();
    }


    // =====================================================
    // Like / Unlike Tweet
    // Toggle like and create/remove notification
    // =====================================================

    public function like(Tweet $tweet)
    {
        // Get authenticated user
        $authUser = auth()->user();

        // Toggle like relationship
        $result = $authUser->likes()->toggle($tweet->id);


        // =====================================================
        // Create Like Notification
        // =====================================================

        if (
            $tweet->user_id !== auth()->id() &&
            auth()->user()->likes()->where('tweet_id', $tweet->id)->exists()
        ) {
            Notification::create([
                'user_id' => $tweet->user_id,
                'actor_id' => auth()->id(),
                'tweet_id' => $tweet->id,
                'type' => 'like',
            ]);
        }

        // =====================================================
        // Like Added
        // Create notification for tweet owner
        // =====================================================

        if (!empty($result['attached'])) {

            // Don't notify yourself
            if ($tweet->user_id !== $authUser->id) {

                \App\Models\Notification::firstOrCreate([
                    'user_id' => $tweet->user_id,
                    'actor_id' => $authUser->id,
                    'tweet_id' => $tweet->id,
                    'type' => 'like',
                ]);

            }

        }

        // =====================================================
        // Like Removed
        // Delete existing notification
        // =====================================================

        if (!empty($result['detached'])) {

            \App\Models\Notification::where([
                'user_id' => $tweet->user_id,
                'actor_id' => $authUser->id,
                'tweet_id' => $tweet->id,
                'type' => 'like',
            ])->delete();

        }

        return back();
    }

    // =====================================================
    // Delete Tweet
    // Only the owner of the tweet can delete it.
    // =====================================================

    public function destroy(Tweet $tweet)
    {
        // Check if the logged-in user owns this tweet
        if ($tweet->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete all likes
        $tweet->likes()->detach();

        // Delete all comments
        $tweet->comments()->delete();

        // Delete the tweet
        $tweet->delete();

        // Return back to previous page
        return back();
    }

    public function edit(Tweet $tweet)
    {
        if ($tweet->user_id !== auth()->id()) {
            abort(403);
        }

        return view('tweets.edit-tweet', compact('tweet'));
    }

    public function update(Request $request, Tweet $tweet)
    {
        // Check if the logged-in user owns this tweet
        if ($tweet->user_id !== auth()->id()) {
            abort(403);
        }

        // Validate tweet text
        $request->validate([
            'body' => 'required|max:280',
        ]);

        // Update tweet body
        $tweet->update([
            'body' => $request->body,
        ]);

        // Redirect to home page
        return redirect()->route('home');
    }

    public function show(Tweet $tweet)
    {
        $tweet->load([
            'user.medias',
            'medias',
            'comments.user.medias',
            'comments.medias',
        ]);

        $tweet->loadCount([
            'likes',
            'comments',
            'retweets',
        ]);

        return view('tweets.show', compact('tweet'));
    }


}
