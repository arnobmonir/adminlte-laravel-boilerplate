<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Authorization\Role;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role
        Role::insert([
            ['name' => 'Developer', 'label' => 'System Developer'],
            ['name' => 'Admin', 'label' => 'System Admin'],
            ['name' => 'Moderator', 'label' => 'System Moderator'],
        ]);
        $this->command->info('Role Created');
        // User
        User::insert([
            [
                'uuid' => 'BDC0000',
                'name' => 'Developer',
                'email' => 'dev@me.com',
                'password' => bcrypt('12345678')
            ],
            [
                'uuid' => 'BDC0001',
                'name' => 'Master Admin',
                'email' => 'admin@me.com',
                'password' => bcrypt('12345678')

            ],
            [
                'uuid' => 'BDC0002',
                'name' => 'Operator',
                'email' => 'operator@me.com',
                'password' => bcrypt('12345678')

            ],
        ]);
        $this->command->info('User  Created');
        // Assign Role
        $role = User::find(1);
        $role->roles()->sync([1]);

        $role = User::find(2);
        $role->roles()->sync([2]);

        $role = User::find(3);
        $role->roles()->sync([3]);
    }
}
