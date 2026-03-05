<?php

namespace Database\Seeders;

use App\Models\XpNeedPerLevel;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class XpNeedPerLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset.
        Schema::disableForeignKeyConstraints();
        XpNeedPerLevel::truncate();
        Schema::enableForeignKeyConstraints();

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
