<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRarity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
