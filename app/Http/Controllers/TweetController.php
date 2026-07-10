<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'body' => 'required|max:280',
        ]);

        // Save the tweet for the logged-in user
        auth()->user()->tweets()->create([
            'body' => $request->body,
        ]);

        // Go back to home page
        return redirect()->back();
    }
}
