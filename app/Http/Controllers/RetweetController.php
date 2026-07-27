<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRetweetRequest;
use App\Models\Retweet;
use App\Models\Tweet;
use App\Models\Notification;


class RetweetController extends Controller
{
    // =====================================================
    // Retweet / Undo Retweet
    // =====================================================
    public function toggle(Tweet $tweet)
    {
        // Check if the user already retweeted this tweet
        $retweet = Retweet::where('user_id', auth()->id())
            ->where('tweet_id', $tweet->id)
            ->first();

        // Undo retweet
        if ($retweet) {

            $retweet->delete();

        } else {

            // Create new retweet
            Retweet::create([
                'user_id' => auth()->id(),
                'tweet_id' => $tweet->id,
            ]);

            // =====================================================
            // Create Retweet Notification
            // =====================================================

            if ($tweet->user_id !== auth()->id()) {

                Notification::create([
                    'user_id' => $tweet->user_id,
                    'actor_id' => auth()->id(),
                    'tweet_id' => $tweet->id,
                    'type' => 'retweet',
                ]);

            }
        }

        return back();
    }

    // =====================================================
    // Quote Tweet
    // Create a new tweet that quotes another tweet
    // =====================================================

    public function store(StoreRetweetRequest $request, Tweet $tweet)
    {
        // Create the quote tweet
        $quoteTweet = Tweet::create([
            'user_id' => auth()->id(),
            'body' => $request->body,
            'quote_tweet_id' => $tweet->id,
        ]);

        // =====================================================
        // Create Quote Tweet Notification
        // =====================================================

        if ($tweet->user_id !== auth()->id()) {

            Notification::firstOrCreate([
                'user_id' => $tweet->user_id,
                'actor_id' => auth()->id(),
                'tweet_id' => $tweet->id,
                'type' => 'quote',
            ]);

        }

        return redirect()->route('tweets.show', $quoteTweet);
    }

}
