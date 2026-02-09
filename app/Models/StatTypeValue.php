<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatTypeValue extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'stat_id',
        'stat_type_id',
        'value',
    ];

    public function stat() {
        return $this->belongsTo(Stat::class);
    }
    public function statType() {
        return $this->belongsTo(StatType::class);
    }
}
