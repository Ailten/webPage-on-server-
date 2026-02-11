<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Utils\Enum\Roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset.
        Role::all()->delete();

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
