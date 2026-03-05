<?php

namespace Database\Seeders;

use App\Models\CharacterSpecie;
use App\Utils\Enum\CharacterSpecies;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CharacterSpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset.
        Schema::disableForeignKeyConstraints();
        CharacterSpecie::truncate();
        Schema::enableForeignKeyConstraints();

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
