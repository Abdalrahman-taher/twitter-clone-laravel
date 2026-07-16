<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class HomeController extends Controller
{
    public function index()
    {
        // =====================================================
        // Get all parent tweets (newest first)
        // Exclude comments by checking parent_id is null
        // Eager load user, media, likes and comments
        // =====================================================

        $tweets = Tweet::whereNull('parent_id')
            ->with([
                'user',
                'medias',
                'likes',
                'comments.user',
            ])
            // Count the number of likes and comments for each tweet
            ->withCount(
                'likes',
                'comments',
            )
            ->latest()
            ->get();

        // =====================================================
        // Return Home Page
        // =====================================================

        return view('home.index', compact('tweets'));
    }
}
