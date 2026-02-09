<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertRow('Player');
        $this->insertRow('Admin');
        $this->insertRow('Banned');
    }

    private function insertRow(string $name) {
        DB::table('roles')->insert([
            'name' => $name
        ]);
    }
}
