<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// use Spatie\Permission\Contracts\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()

    {
        $this->call(CreateAdminUserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionTableSeeder::class);

        // \App\Models\User::factory(10)->create();
    }
}
