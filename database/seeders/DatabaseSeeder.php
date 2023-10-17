<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(DepartmentSeeder::class);
        // $this->call(UserSeeder::class);
        // User::Factory(10)->create();
        $this->call(PermissionSeeder::class);
        // $this->call(FolderSeeder::class);
        // $this->call(FileSeeder::class);
        // $this->call(PermissionUserSeeder::class);
    }
}
