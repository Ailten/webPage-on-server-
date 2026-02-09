<?php

namespace App\Models;

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

}
