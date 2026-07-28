<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;

class FollowController extends Controller
{
    // =====================================================
    // Follow User
    // Create a new follow relationship
    // =====================================================
    public function store(User $user): RedirectResponse
    {
        // Get authenticated user
        $authUser = auth()->user();
        $alreadyFollowing = $authUser->isFollowing($user);

        // Follow selected user
        $authUser->follow($user);

        // =====================================================
        // Create Follow Notification
        // Don't notify yourself
        // =====================================================

        if ($authUser->id !== $user->id && !$alreadyFollowing) {

            Notification::send($user->id, [
                'message' => $authUser->name . ' started following you.',
                'target' => route('profile.show', $authUser),
            ]);

        }

        // Return back
        return back();
    }

    // =====================================================
    // Unfollow User
    // Remove an existing follow relationship
    // =====================================================
    public function destroy(User $user): RedirectResponse
    {
        // Get authenticated user
        $authUser = auth()->user();

        // Unfollow selected user
        $authUser->unfollow($user);

        // =====================================================
        // Remove Follow Notification
        // =====================================================

        Notification::where('user_id', $user->id)
            ->where('content->message', $authUser->name . ' started following you.')
            ->where('content->target', route('profile.show', $authUser))
            ->delete();

        // Return back
        return back();
    }
}
