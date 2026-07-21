<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tweet;



class SearchController extends Controller
{
    // =====================================================
    // Search Page
    // Display search page and receive search query
    // =====================================================

    public function index(Request $request)
    {
        $query = trim($request->q);

        // =====================================================
        // Search Users
        // =====================================================

        $users = User::query()
            ->when($query, function ($q) use ($query) {

                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('username', 'like', "%{$query}%");

            })
            ->with('medias')
            ->orderBy('name')
            ->get();

        // =====================================================
        // Search Tweets
        // =====================================================

        $tweets = Tweet::query()
            ->whereNull('parent_id')
            ->when($query, function ($q) use ($query) {

                $q->where('body', 'like', "%{$query}%");

            })
            ->with([
                'user.medias',
                'medias',
                'likes',
                'comments',
            ])
            ->withCount([
                'likes',
                'comments',
                'retweets',
            ])
            ->latest()
            ->get();

        return view('search.index', [
            'query' => $query,
            'users' => $users,
            'tweets' => $tweets,
        ]);
    }
}
