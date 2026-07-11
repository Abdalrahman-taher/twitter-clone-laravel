<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TweetController extends Controller
{
    public function store(Request $request)
    {
        // =====================================================
        // Validate Tweet Data
        // Check tweet text, image and video before saving
        // =====================================================

        $request->validate([
            'body' => 'required|max:280',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|mimes:mp4',
        ]);


        // =====================================================
        // Default Values
        // If the user doesn't upload anything,
        // image and video stay null.
        // =====================================================

        $imagePath = null;
        $videoPath = null;


        // =====================================================
        // Upload Image
        // Save image inside storage/app/public/tweets/images
        // =====================================================

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store(
                'tweets/images',
                'public'
            );

        }


        // =====================================================
        // Upload Video
        // Save video inside storage/app/public/tweets/videos
        // =====================================================

        if ($request->hasFile('video')) {

            $videoPath = $request->file('video')->store(
                'tweets/videos',
                'public'
            );

        }


        // =====================================================
        // Save Tweet
        // Create a new tweet for the logged-in user
        // =====================================================

        auth()->user()->tweets()->create([

            'body' => $request->body,

            'image' => $imagePath,

            'video' => $videoPath,

        ]);


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
