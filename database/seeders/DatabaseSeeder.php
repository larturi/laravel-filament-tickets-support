<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            RolesSeeder::class,
            PermissionsSeeder::class,
            PermissionRoleSeeder::class,
            RoleUserSeeder::class
        ]);
    }
}
