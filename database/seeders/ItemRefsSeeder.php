<?php

namespace Database\Seeders;

use App\Models\ItemCategorie;
use App\Models\ItemRarity;
use App\Models\ItemRef;
use App\Models\Stat;
use App\Models\StatType;
use App\Models\StatTypeValue;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemRefsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertRow('mucus de slime', 1, 1, 'ressource', 'commun');
        $this->insertRow('noyau de slime', 3, 1, 'pierre précieuse', 'peu commun');
        $this->insertRow('racine de petit bois', 1, 1, 'ressource', 'commun');
        $this->insertRow('bois petit', 3, 1, 'bois', 'peu commun');
        $this->insertRow('caillou', 1, 1, 'ressource', 'commun');
        $this->insertRow('mineré de plomb', 3, 1, 'mineré', 'peu commun');

        $this->insertRow('lingo de plomb', 7, 1, 'lingo', 'peu commun');
        $this->insertRow('planche petite', 7, 1, 'planche', 'peu commun');

        $this->insertWithStat('baton gluant', 6, 1, 'arme', 'peu commun', [
            'soigne eau' => 6,
            'vie' => 5,
            'maitrise eau' => 10,
            'soin eau' => 1,
        ]);
        $this->insertWithStat('bouclier de pierre', 6, 1, 'arme', 'peu commun', [
            '%agro terre' => 8,
            '%agro eau' => 4,
            'vie' => 8,
            'res. feu' => 1,
        ]);
        $this->insertWithStat('marteau de pierre', 6, 1, 'arme', 'peu commun', [
            'attaque terre' => 6,
            'vie' => 3,
            'maitrise terre' => 10,
            'critique' => 1,
        ]);
        $this->insertWithStat('anneau gluant', 6, 1, 'bijou', 'peu commun', [
            'maitrise eau' => 15,
            'maitrise air' => 10,
            'dommage feu' => 1,
            'esquive' => 1,
        ]);
        $this->insertWithStat('casque petit', 6, 1, 'casque', 'peu commun', [
            'vie' => 8,
            'maitrise air' => 10,
            'maitrise terre' => 5,
            'res. terre' => 1,
        ]);
        $this->insertWithStat('armur de rock', 6, 1, 'armur', 'peu commun', [
            'vie' => 6,
            'maitrise feu' => 10,
            'maitrise terre' => 5,
            'res. feu' => 1,
        ]);
        $this->insertWithStat('casque de plomb', 10, 2, 'casque', 'rare', [
            'vie' => 10,
            'maitrise terre' => 15,
            'maitrise air' => 15,
            'res. feu' => -1,
            'res. eau' => -1,
            'res. terre' => 1,
        ]);
        $this->insertWithStat('armure petite', 10, 2, 'armur', 'rare', [
            'vie' => 15,
            'maitrise terre' => 5,
            'maitrise air' => 5,
            'soin terre' => 1,
            'res. feu' => -1,
            'res. eau' => 1,
        ]);
        $this->insertWithStat('anneau gris', 8, 2, 'bijou', 'rare', [
            'vie' => 8,
            'maitrise feu' => 15,
            'dommage feu' => 1,
            'soin feu' => 1,
            'res. eau' => -2,
        ]);
    }

    private function insertRow(string $name, int $price, int $level, string $categoryName, string $rarityName) {
        DB::table('item_refs')->insert([
            'name' => $name,
            'price' => $price,
            'level' => $level,
            'item_categorie_id' => ItemCategorie::where('name', '=', $categoryName)->first()->id,
            'item_rarity_id' => ItemRarity::where('name', '=', $rarityName)->first()->id,
        ]);
    }

    private function insertWithStat(string $name, int $price, int $level, string $categoryName, string $rarityName, $statsArray){
        $this->insertRow($name, $price, $level, $categoryName, $rarityName);
        
        $stat = Stat::create([]);
        $itemRef = ItemRef::where('name', '=', $name)->first();
        $itemRef->stat_id = $stat->id;
        $itemRef->save();

        foreach($statsArray as $key => $value) {
            StatTypeValue::create([
                'stat_id' => $stat->id,
                'stat_type_id' => StatType::where('name', '=', $key)->first()->id,
                'value' => $value,
            ]);
        }
    }
}
