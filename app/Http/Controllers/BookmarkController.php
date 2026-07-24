<?php

namespace App\Http\Controllers;

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
        auth()->user()->bookmarks()->toggle($tweet->id);

        return back();
    }
}
