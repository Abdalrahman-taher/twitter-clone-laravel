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
        $userId = auth()->id();
        $alreadyInteracted = $tweet->retweets()
            ->where('user_id', $userId)
            ->exists()
            || $tweet->quotedBy()
                ->where('user_id', $userId)
                ->exists();

        // Undo retweet or quote tweet
        if ($alreadyInteracted) {

            $tweet->retweets()
                ->where('user_id', $userId)
                ->detach();

            $tweet->quotedBy()
                ->where('user_id', $userId)
                ->delete();

        } else {

            // Create new retweet
            Retweet::create([
                'user_id' => $userId,
                'tweet_id' => $tweet->id,
            ]);

            // =====================================================
            // Create Retweet Notification
            // =====================================================

            if ($tweet->user_id !== $userId) {

                Notification::send($tweet->user_id, [
                    'message' => auth()->user()->name . ' retweeted your tweet.',
                    'target' => route('tweets.show', $tweet),
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
        $userId = auth()->id();

        $alreadyInteracted = $tweet->retweets()
            ->where('user_id', $userId)
            ->exists()
            || $tweet->quotedBy()
                ->where('user_id', $userId)
                ->exists();

        if ($alreadyInteracted) {
            return back();
        }

        // Create the quote tweet
        $quoteTweet = Tweet::create([
            'user_id' => $userId,
            'body' => $request->body,
            'quote_tweet_id' => $tweet->id,
        ]);

        // =====================================================
        // Create Quote Tweet Notification
        // =====================================================

        if ($tweet->user_id !== $userId) {

            Notification::send($tweet->user_id, [
                'message' => auth()->user()->name . ' quoted your tweet.',
                'target' => route('tweets.show', $tweet),
            ]);

        }

        return redirect()->route('tweets.show', $quoteTweet);
    }

}
