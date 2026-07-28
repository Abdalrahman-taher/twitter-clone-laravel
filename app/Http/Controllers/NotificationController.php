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
        // Get latest notifications
        // =====================================================

        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->get();

        // =====================================================
        // Mark Notifications As Read
        // =====================================================

        auth()->user()
            ->notifications()
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        // =====================================================
        // Return Notifications Page
        // =====================================================

        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }
}
