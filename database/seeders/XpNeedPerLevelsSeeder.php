<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class XpNeedPerLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertRow(1, 100);
        $this->insertRow(2, 500);
        $this->insertRow(3, 800);
        $this->insertRow(4, 1300);
        $this->insertRow(5, 2000);
        $this->insertRow(6, 2500);
        $this->insertRow(7, 3200);
        $this->insertRow(8, 4000);
        $this->insertRow(9, 4700);
    }

    private function insertRow(int $level, int $xpNeed) {
        DB::table('xp_need_per_levels')->insert([
            'level' => $level,
            'xp_need' => $xpNeed
        ]);
    }
}
