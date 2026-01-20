<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CharacterSpeciesSeeder::class,
            XpNeedPerLevelsSeeder::class,
            StatTypesSeeder::class,
            ItemCategoriesSeeder::class,
            ItemRaritiesSeeder::class,
            ItemRefsSeeder::class,
            CraftsSeeder::class,
            MobsSeeder::class,
        ]);
    }
}
