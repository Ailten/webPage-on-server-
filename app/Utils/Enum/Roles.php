<?php

namespace App\Utils\Enum;

enum Roles: int {
    case Player = 1;
    case Admin = 2;
    case Banned = 3;
}