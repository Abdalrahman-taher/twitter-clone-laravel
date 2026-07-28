<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTweetRequest;
use App\Http\Requests\StoreTweetRequest;
use App\Models\Notification;
use App\Models\Tweet;
use App\Traits\HandlesMediaUploads;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    use HandlesMediaUploads;

    public function store(StoreTweetRequest $request)
    {
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
        $authUser = auth()->user();

        $result = $authUser->likes()->toggle($tweet->id);

        if (!empty($result['attached'])) {
            if ($tweet->user_id !== $authUser->id) {
                Notification::send($tweet->user_id, [
                    'message' => $authUser->name . ' liked your tweet.',
                    'target' => route('tweets.show', $tweet),
                ]);
            }
        }

        if (!empty($result['detached'])) {
            Notification::where('user_id', $tweet->user_id)
                ->where('content->message', $authUser->name . ' liked your tweet.')
                ->where('content->target', route('tweets.show', $tweet))
                ->delete();
        }

        return back();
    }

    public function destroy(Tweet $tweet)
    {
        if ($tweet->user_id !== auth()->id()) {
            abort(403);
        }

        $tweet->likes()->detach();
        $tweet->comments()->delete();
        $tweet->delete();

        return back();
    }

    public function edit(Tweet $tweet)
    {
        if ($tweet->user_id !== auth()->id()) {
            abort(403);
        }

        return view('tweets.edit-tweet', compact('tweet'));
    }

    public function update(UpdateTweetRequest $request, Tweet $tweet)
    {
        if ($tweet->user_id !== auth()->id()) {
            abort(403);
        }

        $tweet->update([
            'body' => $request->body,
        ]);

        return redirect()->route('home');
    }

    public function show(Tweet $tweet)
    {
        $tweet->load([
            'user.medias',
            'medias',
            'comments.user.medias',
            'comments.medias',
            'quoteTweet.user.medias',
            'quoteTweet.medias',
        ]);

        $tweet->loadCount([
            'likes',
            'comments',
            'retweets',
        ]);

        return view('tweets.show', compact('tweet'));
    }
}
