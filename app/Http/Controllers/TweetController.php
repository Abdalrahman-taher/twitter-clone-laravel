<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
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
        // Upload Tweet Images
        // Save each uploaded image as a separate media record
        // =====================================================


        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('tweets/images', 'public');

                $tweet->medias()->create([
                    'collection' => 'tweet',
                    'path' => $path,
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);
            }
        }


        // =====================================================
        // Upload Tweet Videos
        // Save each uploaded video as a separate media record
        // =====================================================

        if ($request->hasFile('videos')) {

            foreach ($request->file('videos') as $video) {

                $path = $video->store('tweets/videos', 'public');

                $tweet->medias()->create([
                    'collection' => 'tweet',
                    'path' => $path,
                    'mime_type' => $video->getMimeType(),
                    'size' => $video->getSize(),
                ]);
            }
        }
        // =====================================================
        // Return Back
        // Go back to home page
        // =====================================================

        return redirect()->back();
    }

    // =====================================================
    // Like / Unlike Tweet
    // If the user already liked the tweet, remove the like.
    // =====================================================

    public function like(Tweet $tweet)
    {
        auth()->user()->likes()->toggle($tweet->id);

        return back();
    }
}
