<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mob extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'stat_id',
        'name',
        'level',
        'xp_given',
        'gold_given',
    ];
}
