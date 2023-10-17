<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'name'      =>  'IT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'QA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'HRD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'GA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'FA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'PPIC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'Purchase',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'WH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'QC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'CPL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'Engineer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Plabottle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Softbag',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'Ampoule',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'TD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'MD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'      =>  'EN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($departments as $departmentData) {
            $department = Department::create($departmentData);
            // Generate slug berdasarkan pengaturan di Model Folder
            $department->save();
        }
    }
}
