<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->command->info('Initializing...');
        $this->command->info('Deleting tables...');
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_user')->truncate();
        DB::table('permissions')->truncate();
        $this->command->info('Deleted tables!');
        $this->command->info('Creating Tables...');
        $this->call(
            [
                UserSeeder::class,
                PermissionSeeder::class,
            ]
        );
        $this->command->info('Finished!');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
