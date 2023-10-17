<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = [
            [
                'name'       => 'Production',
                'mime_type' => 'application/pdf',
                'ext' => 'pdf',
                'original_size' => '255',
                'formatted_size_unit' => 'KB',
                'file_path' => 'Ampoule/Ampoule - Production/Production.pdf',
                'file_link' => 'storage/Ampoule/Ampoule - Production/Production.pdf',
                'user_id'    => '1',
                'dept_id' => '1',
                'parent_folder_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Training',
                'mime_type' => 'application/pdf',
                'ext' => 'pdf',
                'original_size' => '340',
                'formatted_size_unit' => 'KB',
                'file_path' => 'Ampoule/Ampoule - Training/Training.pdf',
                'file_link' => 'storage/Ampoule/Ampoule - Training/Training.pdf',
                'user_id'    => '2',
                'dept_id' => '2',
                'parent_folder_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'K3',
                'mime_type' => 'image/jpg',
                'ext' => 'jpg',
                'original_size' => '500',
                'formatted_size_unit' => 'KB',
                'file_path' => 'Ampoule/Ampoule - K3/K3.jpg',
                'file_link' => 'storage/Ampoule/Ampoule - K3/K3.jpg',
                'user_id'    => '3',
                'dept_id' => '3',
                'parent_folder_id' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'SOP',
                'mime_type' => 'application/pdf',
                'ext' => 'pdf',
                'original_size' => '720',
                'formatted_size_unit' => 'KB',
                'file_path' => 'Ampoule/Ampoule - Production/Production Folder - 1/sop.pdf',
                'file_link' => 'storage/Ampoule/Ampoule - Production/Production Folder - 1/sop.pdf',
                'user_id'    => '3',
                'dept_id' => '4',
                'parent_folder_id' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Folder::insert($folders);

        foreach ($files as $fileData) {
            $file = File::create($fileData);
            // Generate slug berdasarkan pengaturan di Model Folder
            $file->save();
        }
    }
}
