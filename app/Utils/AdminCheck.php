<?php

namespace App\Utils\Admin;

use App\Models\User;
use App\Utils\Enum\Roles;

class AdminCheck {

    public static function isAdmin(User $user): bool {
        return ($user->role_id == Roles::Admin);
    }
}