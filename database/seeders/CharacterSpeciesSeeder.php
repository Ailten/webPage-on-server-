<?php

namespace Database\Seeders;

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
        $this->insertRow('Mercenaire');
        $this->insertRow('Tank');
        $this->insertRow('Soigneur');
    }

    private function insertRow(string $name) {
        DB::table('character_species')->insert([
            'name' => $name
        ]);
    }
}
