<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Utils\Enum\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset.
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        foreach(Roles::cases() as $r) {
            $this->insertRowWithId($r->value, $r->name);
        }
    }

    private function insertRowWithId(int $id, string $name) {
        $role = new Role();
        $role->id = $id;
        $role->name = $name;
        $role->save();
    }
}
