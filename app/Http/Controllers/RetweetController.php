<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRetweetRequest;
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
        $authUser = auth()->user();
        $hasRetweet = $tweet->retweets()
            ->wherePivot('user_id', $userId)
            ->exists();
        $hasQuote = $tweet->quotedBy()
            ->where('user_id', $userId)
            ->exists();

        // Switch quote tweet to retweet
        if ($hasQuote) {

            $tweet->quotedBy()
                ->where('user_id', $userId)
                ->delete();

            Notification::where('user_id', $tweet->user_id)
                ->where('content->message', $authUser->name . ' quoted your tweet.')
                ->where('content->target', route('tweets.show', $tweet))
                ->delete();

            if (!$hasRetweet) {
                $tweet->retweets()->attach($userId);

                if ($tweet->user_id !== $userId) {
                    Notification::send($tweet->user_id, [
                        'message' => $authUser->name . ' retweeted your tweet.',
                        'target' => route('tweets.show', $tweet),
                    ]);
                }
            }

            return back();

        } else {

            $result = $tweet->retweets()->toggle($userId);

            if (!empty($result['detached'])) {
                Notification::where('user_id', $tweet->user_id)
                    ->where('content->message', $authUser->name . ' retweeted your tweet.')
                    ->where('content->target', route('tweets.show', $tweet))
                    ->delete();

                return back();
            }

            // Create new retweet
            if ($tweet->user_id !== $userId) {
                Notification::send($tweet->user_id, [
                    'message' => $authUser->name . ' retweeted your tweet.',
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
        $authUser = auth()->user();

        $hasQuote = $tweet->quotedBy()
            ->where('user_id', $userId)
            ->exists();

        if ($hasQuote) {
            return back();
        }

        $hasRetweet = $tweet->retweets()
            ->wherePivot('user_id', $userId)
            ->exists();

        if ($hasRetweet) {
            $tweet->retweets()->detach($userId);

            Notification::where('user_id', $tweet->user_id)
                ->where('content->message', $authUser->name . ' retweeted your tweet.')
                ->where('content->target', route('tweets.show', $tweet))
                ->delete();
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
                'message' => $authUser->name . ' quoted your tweet.',
                'target' => route('tweets.show', $tweet),
            ]);

        }

        return redirect()->route('tweets.show', $quoteTweet);
    }

}
