<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name'       => 'Download File',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Create Folder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Upload File',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       =>  'Edit Delete Folder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       =>  'Edit Delete File',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Open Folder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Open File',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ];

        Permission::insert($permissions);
    }
}
