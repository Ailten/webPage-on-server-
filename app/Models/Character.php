<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'character_spacie_id',
        'stats_id',
        'pseudo',
    ];
}
