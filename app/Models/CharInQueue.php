<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharInQueue extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = [
        'bot_twitch_id',
        'character_id',
    ];


    public function botTwitch() {
        return $this->belongsTo(BotTwitch::class);
    }
    public function character() {
        return $this->belongsTo(Character::class);
    }

}
