<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemRaritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertRow('commun');
        $this->insertRow('peu commun');
        $this->insertRow('rare');
        $this->insertRow('legendaire');
        $this->insertRow('mythique');
    }

    private function insertRow(string $name) {
        DB::table('item_rarities')->insert([
            'name' => $name
        ]);
    }
}
