<?php

namespace App\Http\Controllers;

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
}
