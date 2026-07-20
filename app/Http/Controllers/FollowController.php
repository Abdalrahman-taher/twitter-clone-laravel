<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class FollowController extends Controller
{
    // =====================================================
    // Follow User
    // Create a new follow relationship
    // =====================================================
    public function store(User $user): RedirectResponse
    {
        // Follow the selected user
        auth()->user()->follow($user);

        // Return back to the previous page
        return back();
    }

    // =====================================================
    // Unfollow User
    // Remove an existing follow relationship
    // =====================================================
    public function destroy(User $user): RedirectResponse
    {
        // Unfollow the selected user
        auth()->user()->unfollow($user);

        // Return back to the previous page
        return back();
    }
}
