<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // =====================================================
        // Get all parent tweets (newest first)
        // Exclude comments by checking parent_id is null
        // =====================================================

        $tweets = Tweet::whereNull('parent_id')

            // Load related models
            ->with([
                'user',
                'medias',
                'likes',
                'comments.user',
            ])

            // Count likes and comments
            ->withCount([
                'likes',
                'comments',
            ])

            // Count retweets from retweets table
            ->addSelect([
                'retweets_count' => DB::table('retweets')
                    ->selectRaw('count(*)')
                    ->whereColumn('retweets.tweet_id', 'tweets.id')
            ])

            ->latest()
            ->get();

        // =====================================================
        // Return Home Page
        // =====================================================

        return view('home.index', compact('tweets'));
    }
}
