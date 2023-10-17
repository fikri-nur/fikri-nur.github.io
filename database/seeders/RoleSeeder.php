<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name'       => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Superuser',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Role::insert($roles);
    }
}
