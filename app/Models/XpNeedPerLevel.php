<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XpNeedPerLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'xp_need',
    ];
}
