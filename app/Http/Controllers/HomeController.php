<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Retweet;

class HomeController extends Controller
{
    public function index()
    {
        // =====================================================
        // Get Following Users IDs
        // Include authenticated user to always show own tweets
        // =====================================================

        $followingIds = auth()->user()
            ->following()
            ->pluck('users.id')
            ->push(auth()->id());


        // =====================================================
        // Get normal tweets
        // Show only tweets from followed users
        // =====================================================

        $tweets = Tweet::whereNull('parent_id')
            ->whereIn('user_id', $followingIds)
            ->with([
                'user.medias',
                'medias',
                'likes',
                'comments.user',
                'comments.user.medias',
            ])
            ->withCount([
                'likes',
                'comments',
                'retweets',
            ])
            ->latest()
            ->get()
            ->map(function ($tweet) {

                $tweet->type = 'tweet';

                return $tweet;

            });


        // =====================================================
        // Get retweets
        // =====================================================

        $retweets = Retweet::whereIn('user_id', $followingIds)
            ->with([
                'user.medias',
                'tweet' => function ($query) {
                    $query->withCount([
                        'likes',
                        'comments',
                        'retweets',
                    ]);
                },
                'tweet.user.medias',
                'tweet.medias',
                'tweet.likes',
                'tweet.comments.user',
                'tweet.comments.user.medias',
            ])
            ->latest()
            ->get()
            ->map(function ($retweet) {

                $retweet->type = 'retweet';

                return $retweet;

            });


        // =====================================================
        // Merge tweets and retweets
        // Sort by latest activity
        // =====================================================

        $feed = $tweets
            ->merge($retweets)
            ->sortByDesc('created_at')
            ->values();


        // =====================================================
        // Return Home Page
        // =====================================================

        return view('home.index', compact('feed'));
    }
}
