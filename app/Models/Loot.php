<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loot extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'mob_id',
        'item_ref_id',
        'rate',
    ];
}
