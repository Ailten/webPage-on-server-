<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equiped extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'character_id',
        'inventory_id',
    ];
}
