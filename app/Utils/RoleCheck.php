<?php

namespace App\Utils;

use App\Models\User;
use App\Utils\Enum\Roles;

class RoleCheck {

    public static function isAdmin(User $user): bool {
        return ($user->role_id == Roles::Admin);
    }

    public static function isBanned(User $user): bool {
        return ($user->role_id == Roles::Banned);
    }
}