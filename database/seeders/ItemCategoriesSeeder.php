<?php

namespace Database\Seeders;

use App\Models\ItemCategorie;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ItemCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset.
        Schema::disableForeignKeyConstraints();
        ItemCategorie::truncate();
        Schema::enableForeignKeyConstraints();

        $this->insertRow('casque');
        $this->insertRow('armure');
        $this->insertRow('arme');
        $this->insertRow('bijou');
        $this->insertRow('ressource');
        $this->insertRow('comestible');
        $this->insertRow('bois');
        $this->insertRow('planche');
        $this->insertRow('mineré');
        $this->insertRow('lingo');
        $this->insertRow('pierre précieuse');
    }

    private function insertRow(string $name) {
        DB::table('item_categories')->insert([
            'name' => $name
        ]);
    }
}
