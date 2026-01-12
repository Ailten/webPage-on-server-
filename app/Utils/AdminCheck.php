<?php

namespace App\Utils\Admin;

use App\Models\User;

class AdminCheck {

    private const ADMIN_TWITCH_ID = [
        450998053
    ];

    public static function isAdmin(User $user): bool {

        return in_array($user->twitch_id, AdminCheck::ADMIN_TWITCH_ID);

    }
}