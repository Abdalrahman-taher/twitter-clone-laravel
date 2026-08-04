<?php

namespace App\Services;

use Kreait\Firebase\Contract\Database;

class FirebaseService
{
    public function __construct(
        private Database $database
    )

    {

    }

    public function sendNotification(array $notification): void
    {
        $this->database
            ->getReference('notifications/' . $notification['user_id'])
            ->push($notification);
    }
}
