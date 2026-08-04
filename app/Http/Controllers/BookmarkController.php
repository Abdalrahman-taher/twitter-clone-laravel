<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Tweet;

class BookmarkController extends Controller
{
    // =====================================================
    // Bookmarks Page
    // =====================================================

    public function index()
    {
        $tweets = auth()->user()
            ->bookmarks()
            ->with([
                'user.medias',
                'medias',
                'likes',
                'comments.user.medias',
                'quoteTweet.user.medias',
                'quoteTweet.medias',
            ])
            ->withCount([
                'likes',
                'comments',
                'retweets',
            ])
            ->latest()
            ->get();

        return view('bookmarks.index', [
            'tweets' => $tweets,
        ]);
    }

    // =====================================================
    // Toggle Bookmark
    // =====================================================

    public function toggle(Tweet $tweet)
    {
        $authUser = auth()->user();
        $result = $authUser->bookmarks()->toggle($tweet->id);

        if (!empty($result['attached']) && $tweet->user_id !== $authUser->id) {
            Notification::send($tweet->user_id, [
                'message' => $authUser->name . ' bookmarked your tweet.',
                'target' => route('tweets.show', $tweet),
            ]);
        }

        if (!empty($result['detached'])) {
            Notification::where('user_id', $tweet->user_id)
                ->where('content->message', $authUser->name . ' bookmarked your tweet.')
                ->where('content->target', route('tweets.show', $tweet))
                ->delete();
        }

        return back();
    }
}
