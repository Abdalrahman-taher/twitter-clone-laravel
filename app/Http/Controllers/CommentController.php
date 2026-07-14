<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // =====================================================
    // Store Comment
    // Create a new comment for a tweet
    // =====================================================

    public function store(Request $request, Tweet $tweet)
    {
        // Validate comment text
        $request->validate([
            'body' => 'required|max:280',
        ]);


        // Create comment for the tweet
        $tweet->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);


        // Return back to tweet feed
        return back();
    }
}
