<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // =====================================================
    // Store Comment
    // Create a new reply (stored as a tweet with parent_id)
    // =====================================================

    public function store(Request $request, Tweet $tweet)
    {
        // =====================================================
        // Validate Reply Data
        // Check reply text, images and videos before saving
        // =====================================================

        $request->validate([

            // Reply text
            'body' => 'required|max:280',

            // Reply images
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',

            // Reply videos
            'videos' => 'nullable|array',
            'videos.*' => 'mimes:mp4|max:51200',

        ]);


        // =====================================================
        // Create Reply
        // Store it inside tweets table using parent_id
        // =====================================================

        $reply = $tweet->comments()->create([

            'user_id' => auth()->id(),

            'body' => $request->body,

        ]);


        // =====================================================
        // Upload Reply Images
        // Save each image as media record
        // =====================================================

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('tweets/images', 'public');

                $reply->medias()->create([

                    'collection' => 'reply',

                    'path' => $path,

                    'mime_type' => $image->getMimeType(),

                    'size' => $image->getSize(),

                ]);
            }
        }


        // =====================================================
        // Upload Reply Videos
        // Save each video as media record
        // =====================================================

        if ($request->hasFile('videos')) {

            foreach ($request->file('videos') as $video) {

                $path = $video->store('tweets/videos', 'public');

                $reply->medias()->create([

                    'collection' => 'reply',

                    'path' => $path,

                    'mime_type' => $video->getMimeType(),

                    'size' => $video->getSize(),

                ]);
            }
        }


        // =====================================================
        // Return Back
        // =====================================================

        return back();
    }
}
