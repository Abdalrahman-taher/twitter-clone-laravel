<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class NotificationController extends Controller
{
    // =====================================================
    // Notifications Page
    // Show all notifications for the authenticated user
    // =====================================================

    public function index(): View
    {
        // =====================================================
        // Load User Notifications
        // Get latest notifications with actor and tweet
        // =====================================================

        $notifications = auth()->user()
            ->notifications()
            ->with([
                'actor.medias',
                'tweet',
            ])
            ->latest()
            ->get();

        // =====================================================
        // Mark Notifications As Read
        // =====================================================

        auth()->user()
            ->notifications()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        // =====================================================
        // Return Notifications Page
        // =====================================================

        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }
}
