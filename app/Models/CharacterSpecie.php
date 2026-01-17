<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterSpecie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function Characters() {
        return $this->hasMany(Character::class);
    }
}
