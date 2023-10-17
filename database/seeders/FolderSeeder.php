<?php

namespace Database\Seeders;

use App\Models\Folder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $folders = [
            [
                'name'       => 'IT',
                'folder_path' => 'Root Folder/IT',
                'dept_id'    => '1',
                'user_id'    => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'QA',
                'folder_path' => 'Root Folder/QA',
                'dept_id'    => '2',
                'user_id'    => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'HRD',
                'folder_path' => 'Root Folder/HRD',
                'dept_id'    => '3',
                'user_id'    => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'GA',
                'folder_path' => 'Root Folder/GA',
                'dept_id'    => '4',
                'user_id'    => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'FA',
                'folder_path' => 'Root Folder/FA',
                'dept_id'    => '5',
                'user_id'    => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'PPIC',
                'folder_path' => 'Root Folder/PPIC',
                'dept_id'    => '6',
                'user_id'    => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Purchase',
                'folder_path' => 'Root Folder/Purchase',
                'dept_id'    => '7',
                'user_id'    => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($folders as $folderData) {
            $folder = Folder::create($folderData);
            // Generate slug berdasarkan pengaturan di Model Folder
            Storage::disk('public')->makeDirectory($folder->folder_path);
            $folder->save();
        }

        for ($i = 1; $i <= 2; $i++) {
            $folder1 = [
                'name'       => 'IT - ' . $i,
                'folder_path' => 'Root Folder/IT/IT - ' . $i,
                'folder_id'  => '1',
                'dept_id'    => '1',
                'user_id'    => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Storage::disk('public')->makeDirectory($folder1['folder_path']);
            $folder = Folder::create($folder1);
            $folder->save();
        }

        for ($i = 1; $i <= 2; $i++) {
            $folder2 = [
                'name'       => 'QA - ' . $i,
                'folder_path' => 'Root Folder/QA/QA - ' . $i,
                'folder_id'  => '2',
                'dept_id'    => '2',
                'user_id'    => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Storage::disk('public')->makeDirectory($folder2['folder_path']);
            $folder = Folder::create($folder2);
            $folder->save();
        }

        for ($i = 1; $i <= 1; $i++) {
            $folder3 = [
                'name'       => 'HRD - ' . $i,
                'folder_path' => 'Root Folder/HRD/HRD - ' . $i,
                'folder_id'  => '3',
                'dept_id'    => '3',
                'user_id'    => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Storage::disk('public')->makeDirectory($folder3['folder_path']);
            $folder = Folder::create($folder3);
            $folder->save();
        }
    }
}
