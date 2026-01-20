<?php

namespace Database\Seeders;

use App\Models\Craft;
use App\Models\Ingredient;
use App\Models\ItemRef;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CraftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertRow('baton gluant', 1, 0.95, [
            'mucus de slime' => 1,
            'racine de petit bois' => 1,
            'noyau de slime' => 1,
        ]);
        $this->insertRow('bouclier de pierre', 1, 0.95, [
            'caillou' => 1,
            'mineré de plomb' => 1,
            'mucus de slime' => 1,
        ]);
        $this->insertRow('marteau de pierre', 1, 0.95, [
            'racine de petit bois' => 1,
            'bois petit' => 1,
            'caillou' => 1,
        ]);
        $this->insertRow('anneau gluant', 1, 0.95, [
            'racine de petit bois' => 2,
            'noyau de slime' => 1,
        ]);
        $this->insertRow('casque petit', 1, 0.95, [
            'caillou' => 2,
            'bois petit' => 1,
        ]);
        $this->insertRow('armur de rock', 1, 0.95, [
            'caillou' => 2,
            'mucus de slime' => 3,
        ]);
        $this->insertRow('casque de plomb', 1, 0.95, [
            'lingo de plomb' => 1,
            'mucus de slime' => 1,
            'racine de petit bois' => 1,
        ]);
        $this->insertRow('armure petite', 1, 0.95, [
            'planche petite' => 1,
            'mucus de slime' => 1,
            'caillou' => 1,
        ]);
        $this->insertRow('anneau gris', 1, 0.95, [
            'noyau de slime' => 1,
            'planche petite' => 1,
            'caillou' => 1,
        ]);
    }

    private function insertRow(string $itemRefName, int $quantity, float $rate, $ingredients) {
        $craft = Craft::create([
            'item_ref_id' => ItemRef::where('name', '=', $itemRefName)->first()->id,
            'quantity' => $quantity,
            'rate' => $rate,
        ]);

        foreach($ingredients as $key => $value) {
            Ingredient::create([
                'craft_id' => $craft->id,
                'item_ref_id' => ItemRef::where('name', '=', $key)->first()->id,
                'quantity' => $value,
            ]);
        }
    }
}
