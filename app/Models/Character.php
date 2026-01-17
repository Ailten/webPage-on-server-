<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Character extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'character_specie_id',
        'pseudo',
    ];

    public function characterSpecie() {
        return $this->belongsTo(CharacterSpecie::class);
    }

    protected static function booted()
    {
        // when create Character, create also his Stat.
        static::creating(function ($character) {
            DB::transaction(function () use ($character) {
                $stat = Stat::create([]);
                $character->stat_id = $stat->id;
            });
        });

        // when delete Character, delete also his Stat.
        static::deleting(function ($character) {
            $character->b->delete();
        });
    }
    
}
