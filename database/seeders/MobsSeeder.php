<?php

namespace Database\Seeders;

use App\Models\ItemRef;
use App\Models\Loot;
use App\Models\Mob;
use App\Models\Stat;
use App\Models\StatType;
use App\Models\StatTypeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertRow('slime', 1, 100, 10, [
            'attaque eau' => 8,
            'vie' => 80,
            'res. eau' => 1,
            'critique' => 2,
            'esquive' => 8,
        ], [
            'mucus de slime' => 1.0,
            'noyau de slime' => 0.5,
            'baton gluant' => 0.05,
            'anneau gluant' => 0.05,
            'armur de rock' => 0.05,
        ]);
        $this->insertRow('petit bois', 1, 100, 10, [
            'attaque terre' => 3,
            'vol vie vent' => 3,
            'vie' => 100,
            'critique' => 4,
            'parade' => 4,
        ], [
            'racine de petit bois' => 1.0,
            'bois petit' => 0.5,
            'marteau de pierre' => 0.05,
            'casque petit' => 0.05,
        ]);
        $this->insertRow('caillasse', 1, 100, 10, [
            'attaque terre' => 6,
            'vie' => 50,
            'res. terre' => 1,
            'res. feu' => 1,
            'res. vent' => 1,
            'critique' => 1,
            'parade' => 8,
        ], [
            'caillou' => 1.0,
            'mineré de plomb' => 0.5,
            'bouclier de pierre' => 0.05,
            'armur de rock' => 0.05,
        ]);
    }

    private function insertRow(string $name, int $level, int $xp, int $gold, $statsArray, $lootsArray) {
        $stat = Stat::create([]);

        foreach($statsArray as $key => $value) {
            StatTypeValue::create([
                'stat_id' => $stat->id,
                'stat_type_id' => StatType::where('name', '=', $key)->first()->id,
                'value' => $value,
            ]);
        }

        $mob = Mob::create([
            'name' => $name,
            'level' => $level,
            'xp_given' => $xp,
            'gold_given' => $gold,
            'stat_id' => $stat->id,
        ]);

        foreach($lootsArray as $key => $value) {
            Loot::create([
                'mob_id' => $mob->id, 
                'item_ref_id' => ItemRef::where('name', '=', $key)->first()->id, 
                'rate' => $value
            ]);
        }
    }
}
