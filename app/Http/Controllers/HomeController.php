<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Retweet;
use App\Models\User;

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
                // Tweet owner
                'user.medias',

                // Tweet media
                'medias',

                // Likes
                'likes',

                // Comments
                'comments.user',
                'comments.user.medias',

                // Quote Tweet
                'quoteTweet.user.medias',
                'quoteTweet.medias',
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

                'tweet.quoteTweet.user.medias',
                'tweet.quoteTweet.medias',
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
        // Suggested Users
        // Users that current user does not follow yet
        // =====================================================

        $suggestedUsers = User::where('id', '!=', auth()->id())

            // Exclude already followed users
            ->whereNotIn('id', function ($query) {

                $query->select('following_id')
                    ->from('followers')
                    ->where('follower_id', auth()->id());

            })

            ->with('medias')

            ->inRandomOrder()

            ->limit(3)

            ->get();

        // =====================================================
        // Return Home Page
        // =====================================================

        return view('home.index', compact(
            'feed',
            'suggestedUsers'
        ));    }
}
