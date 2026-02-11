<?php

namespace Database\Seeders;

use App\Models\CharacterSpecie;
use App\Utils\Enum\CharacterSpecies;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharacterSpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset.
        CharacterSpecie::all()->delete();

        foreach(CharacterSpecies::cases() as $cs) {
            $this->insertRowWithId($cs->value, $cs->name);
        }
    }

    private function insertRowWithId(int $id, string $name) {
        $characterSpecie = new CharacterSpecie();
        $characterSpecie->id = $id;
        $characterSpecie->name = $name;
        $characterSpecie->save();
    }
}
