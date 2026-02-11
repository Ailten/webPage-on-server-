<?php

namespace App\Utils\Roles;

enum Roles: int {
    case Player = 1;
    case Admin = 2;
    case Banned = 3;
}