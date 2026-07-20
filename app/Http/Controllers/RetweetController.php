<?php

namespace App\Http\Controllers;

use App\Models\Retweet;
use App\Models\Tweet;

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
        }

        return back();
    }
}
