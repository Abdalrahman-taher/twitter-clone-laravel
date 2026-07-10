<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class HomeController extends Controller
{
    public function index()
    {
        // Get all tweets (newest first) with (Eager Loading)
        $tweets = Tweet::with('user')->latest()->get();
        // Send tweets to the home page
        return view('home.index', compact('tweets'));
    }
}
