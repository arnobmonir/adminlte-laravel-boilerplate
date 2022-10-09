<?php

namespace Database\Seeders;

use App\Models\Authorization\Permission;
use App\Models\Authorization\PermissionGroup;
use App\Models\Authorization\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->command->info('Initializing...');
        $this->command->info('Deleting tables...');
        DB::table('permissions')->truncate();
        DB::table('permission_groups')->truncate();
        $this->command->info('Deleted tables!');
        $this->command->info('Creating Tables...');
        $this->createPermissionGroup();
        $this->createPermission();
        $this->command->info('Finished!');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    public function createPermissionGroup()
    {
        PermissionGroup::insert([
            [
                'id' => 1,
                'parent_id' => null,
                'name' => 'Dashboard'
            ],
            [
                'id' => 2,
                'parent_id' => null,
                'name' => 'Users'
            ],
            [
                'id' => 3,
                'parent_id' => null,
                'name' => 'Roles'
            ],

        ]);
    }
    public function createPermission()
    {
        Permission::insert([
            [
                'permission_group_id' => 1,
                'name' => 'dashboard.show',
                'label' => 'Show Dashboard'
            ],
            // user permission 1
            [
                'permission_group_id' => 2,
                'name' => 'user.show',
                'label' => 'User Show '
            ],
            [
                'permission_group_id' => 2,
                'name' => 'user.create',
                'label' => 'User Create'
            ],
            [
                'permission_group_id' => 2,
                'name' => 'user.edit',
                'label' => 'User Edit'
            ],
            [
                'permission_group_id' => 2,
                'name' => 'user.delete',
                'label' => 'User Delete'
            ],
            // role permission 3
            [
                'permission_group_id' => 3,
                'name' => 'role.show',
                'label' => 'Show Role'
            ],
            [
                'permission_group_id' => 3,
                'name' => 'role.create',
                'label' => 'Create Role'
            ],
            [
                'permission_group_id' => 3,
                'name' => 'role.edit',
                'label' => 'Role Permission edit'
            ],
            [
                'permission_group_id' => 3,
                'name' => 'role.delete',
                'label' => 'Delete Role'
            ],

        ]);
    }
}
