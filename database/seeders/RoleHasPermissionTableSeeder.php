<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Constants\Resource;
class RoleHasPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->createAdminRolePermissions();
    }

    private function createAdminRolePermissions()
    {
        $role = Role::findByName('Administrador');
        $role->syncPermissions(Permission::all());
    }
}
