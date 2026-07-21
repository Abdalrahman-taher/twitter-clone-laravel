<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Traits\HandlesMediaUploads;
use Illuminate\Http\Request;
use App\Models\Notification;

class CommentController extends Controller
{
    use HandlesMediaUploads;

    // =====================================================
    // Store Comment
    // Create a new reply (stored as a tweet with parent_id)
    // =====================================================

    public function store(Request $request, Tweet $tweet)
    {
        // =====================================================
        // Validate Reply Data
        // =====================================================

        $request->validate([

            // Reply text
            'body' => 'nullable|max:280',

            // Reply images
            'comment_images' => 'nullable|array',
            'comment_images.*' => 'image|max:2048',

            // Reply videos
            'comment_videos' => 'nullable|array',
            'comment_videos.*' => 'mimes:mp4|max:51200',

        ]);


        if (
            blank($request->body) &&
            !$request->hasFile('comment_images') &&
            !$request->hasFile('comment_videos')
        ) {
            return back()->withErrors([
                'body' => 'Reply cannot be empty.',
            ]);
        }

        // =====================================================
        // Create Reply
        // =====================================================

        $reply = $tweet->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        // =====================================================
        // Upload Reply Media
        // =====================================================

        $this->uploadMedia(
            $request,
            $reply,
            'comment_images',
            'comment_videos',
            'reply'
        );

        // =====================================================
        // Create Comment Notification
        // Notify tweet owner about the new reply
        // =====================================================

        if ($tweet->user_id !== auth()->id()) {

            Notification::firstOrCreate([
                'user_id' => $tweet->user_id,
                'actor_id' => auth()->id(),
                'tweet_id' => $tweet->id,
                'type' => 'comment',
            ]);

        }

        // =====================================================
        // Return Back
        // =====================================================

        return back();
    }
}
