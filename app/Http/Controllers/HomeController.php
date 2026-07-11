<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class HomeController extends Controller
{
    public function index()
    {
        // Get all tweets (newest first) with (Eager Loading)
        $tweets = Tweet::with([
            'user',
            'likes' // Eager loading -> instead of querying for likes separately
        ])
            //->withCount is a method that counts the number of likes for each tweet to enhance performance
            ->withCount('likes')
            ->latest()
            ->get();
        // Send tweets to the home page
        return view('home.index', compact('tweets'));
    }
}
