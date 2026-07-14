<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class HomeController extends Controller
{
    public function index()
    {
        // =====================================================
        // Get all tweets (newest first)
        // Eager load user, media and likes to improve performance
        // =====================================================

        $tweets = Tweet::with([
            'user',
            'medias',
            'likes',
            'comments.user',
        ])
            // Count the number of likes for each tweet
            ->withCount
            (
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
