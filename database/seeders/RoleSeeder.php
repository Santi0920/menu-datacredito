<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Asociacion']);
        $role3 = Role::create(['name' => 'Credito']);
        $role4 = Role::create(['name' => 'Proveedor']);

        Permission::create(['name' => 'crud.list'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'crud.create'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'crud.update'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'crud.delete'])->syncRoles([$role1, $role2, $role3]);
    }
}
