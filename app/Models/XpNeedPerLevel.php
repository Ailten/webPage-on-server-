<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XpNeedPerLevel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'level',
        'xp_need',
    ];
}
