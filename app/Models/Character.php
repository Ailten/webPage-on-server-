<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Character extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'character_specie_id',
        'pseudo',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function characterSpecie() {
        return $this->belongsTo(CharacterSpecie::class);
    }
    public function stat() {
        return $this->belongsTo(Stat::class);
    }
    public function xpNeedPerLevel() {
        return $this->belongsTo(XpNeedPerLevel::class, 'level', 'level');
    }

    public function inventories() {
        return $this->belongsToMany(Inventory::class, 'equipeds');
    }

    
    public function inventoriesEquiped() {
        $categoriesOrders = ['casque', 'armure', 'arme', 'bijou'];

        $inventories = $this->inventories()
        ->with('item_refs.item_categories')
        ->get();

        $indexed = $inventories->mapWithKeys(function ($in) {
            return [
                $in->item_ref?->item_categories?->name => $in
            ];
        });

        return collect($categoriesOrders)
        ->map(function ($name) use ($indexed) {
            return $indexed->get($name, null) ?? $name;  // take string category if no match.
        });

    }


    protected static function booted()
    {
        // when create Character, create also his Stat.
        static::creating(function ($character) {
            DB::transaction(function () use ($character) {
                $stat = Stat::create([]);

                StatTypeValue::create([
                    'stat_id' => $stat->id,
                    'stat_type_id' => StatType::where('name', '=', 'vie')->first()->id,
                    'value' => 60,
                ]);

                $character->stat_id = $stat->id;
            });
        });

        // when delete Character, delete also his Stat.
        static::deleting(function ($character) {
            $character->stat->delete();
        });
    }
    
}
