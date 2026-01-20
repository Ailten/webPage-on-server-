<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [];


    public function statTypeValues() {
        return $this->hasMany(StatTypeValue::class);
    }

    protected static function booted()
    {
        // when delete Stat, delete also his StatTypeValue.
        static::deleting(function ($stat) {
            $stat->statTypeValues()->delete();
        });
    }

}
