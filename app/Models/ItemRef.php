<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRef extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = [
        'item_categorie_id',
        'item_rarity_id',
        'name',
        'price',
        'level',
    ];


    public function itemCateogrie() {
        return $this->belongsTo(ItemCategorie::class);
    }
    public function itemRarity() {
        return $this->belongsTo(ItemRarity::class);
    }
    public function stat() {
        return $this->belongsTo(Stat::class);
    }
    
}
