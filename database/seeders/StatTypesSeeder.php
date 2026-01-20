<?php

namespace Database\Seeders;

use App\Utils\Elements\Elements;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertFourElements('attaque <e>', 0);
        $this->insertFourElements('soigne <e>', 0);
        $this->insertFourElements('attaque soi <e>', 0);
        $this->insertFourElements('soigne soi <e>', 0);
        $this->insertFourElements('vol vie <e>', 0);
        $this->insertFourElements('%agro <e>', 0);

        $this->insertRow('vie', 1);
        $this->insertFourElements('maitrise <e>', 1);
        $this->insertFourElements('dommage <e>', 3);
        $this->insertFourElements('soin <e>', 3);
        $this->insertFourElements('res. <e>', 3);
        $this->insertFourElements('%res. <e>', 5);

        $this->insertRow('esquive', 8);
        $this->insertRow('parade', 8);
        $this->insertRow('critique', 6);
        $this->insertRow('butin', 8);
        $this->insertRow('memoire', 8);

        $this->insertRow('carac.', 1);
    }

    private function insertRow(string $name, int $weight) {
        DB::table('stat_types')->insert([
            'name' => $name,
            'weight' => $weight
        ]);
    }

    private function insertFourElements(string $name, int $weight){
        foreach(Elements::cases() as $element) {
            DB::table('stat_types')->insert([
                'name' => str_replace('<e>', $element->name, $name),
                'weight' => $weight
            ]);
        }
    }
}
