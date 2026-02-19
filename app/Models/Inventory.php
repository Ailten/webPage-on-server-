<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'item_ref_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function itemRef() {
        return $this->belongsTo(ItemRef::class);
    }
    public function stat() {
        return $this->belongsTo(Stat::class);
    }

    // todo : debug, try if it's work.
    public function stat_or_itemRefStat() {
        //return $this->stat ?? $this->itemRef->stat;

        return $this->hasOne(Stat::class, 'id')
        ->whereIn('id', function($query) {
            $query->selectRaw('coalesce(inventories.stat_id, item_refs.stat_id)')
            ->from('inventories')
            ->join('item_refs', 'item_refs.id', '=', 'inventories.item_ref_id')
            ->whereColumn('inventories.parent_id', 'parents.id');
        });

        //return $this->selectRaw('stat.* where coalesce(inventories.stat_id, item_refs.stat_id) = stat.id');
    }

    // scope for query "get inventori with details".
    public function scopeWithDetailsInventory($query) {
        return $query
            ->leftJoin('equipeds', 'equipeds.inventory_id', '=', 'inventories.id')
            ->leftJoin('characters', 'characters.id', '=', 'equipeds.character_id')
            ->join('item_refs', 'item_refs.id', '=', 'inventories.item_ref_id')
            ->join('item_categories', 'item_categories.id', '=', 'item_refs.item_categorie_id')
            ->join('item_rarities', 'item_rarities.id', '=', 'item_refs.item_rarity_id')
            
            ->paginate(10, [  // pagination.
                'inventories.id as id',
                'inventories.quantity as quantity',
                DB::raw('COUNT(characters.id) as equiped_quantity'),
                'item_refs.name as name',
                'item_refs.price as price',
                'item_refs.level as level',
                'item_categories.name as item_categorie',
                'item_rarities.name as item_rarity',

            ]);
    }

}
