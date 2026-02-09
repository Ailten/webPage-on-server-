<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'item_ref_id',
        'start_sell_date',
        'end_sell_date',
    ];

    protected $casts = [
        'start_sell_date' => 'datetime',
        'end_sell_date' => 'datetime',
    ];
}
