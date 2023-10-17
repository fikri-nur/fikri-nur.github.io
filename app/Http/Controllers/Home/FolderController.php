<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexNestedFolder($slug)
    {
        // Table
        // Pisahkan slug untuk membentuk array berdasarkan '/'
        $dataSlug = explode('/', $slug);

        $folderNames = []; // Buat array kosong untuk nama-nama folder

        // Loop melalui dataSlug untuk mengambil nama folder berdasarkan slug
        foreach ($dataSlug as $data) {
            $getFromSlug = Folder::where('slug', $data)->first();
            if ($getFromSlug) {
                $folderNames[] = $getFromSlug->name;
            } else {
                $folderNames[] = $data; // Jika folder tidak ditemukan, gunakan slug sebagai alternatif
            }
        }

        // Ambil data terakhir dari array slug
        $lastIndex = count($dataSlug) - 1;
        // Ambil data folder berdasarkan slug terakhir
        $openedFolder = Folder::with('department', 'childFolders')->where('slug', $dataSlug[$lastIndex])->first();
        // Ambil child folder dari folder yang dipilih
        $childFolders = Folder::with('department', 'childFolders')->where('folder_id', $openedFolder->id)->orderby('name', 'asc')->get();
        // Ambil file dari folder yang dipilih
        $files = File::with('department')->where('parent_folder_id', $openedFolder->id)->orderby('name', 'asc')->get();

        // Tambahkan atribut 'source' ke setiap folder
        $childFolders->each(function ($folder) use ($slug) {
            $folder->slug = $slug . '/' . $folder->slug;
            $folder->source = 'folder';
        });

        // Tambahkan atribut 'source' ke setiap file
        $files->each(function ($file) {
            $file->source = 'file';
        });

        // Gabungkan data folder dan file
        $combinedDataTable = $childFolders->concat($files);

        // Folder Tree
        $parentFolders = Folder::with('department', 'childFolders')->where('folder_id', '=', null)->orderby('name', 'asc')->get();
        // File tree
        $filesTree = File::where('parent_folder_id', null)->orderby('name', 'asc')->get();
        // Tambahkan atribut 'source' ke setiap folder
        $parentFolders->each(function ($folder) {
            $folder->source = 'folder';
        });
        // Tambahkan atribut 'source' ke setiap file
        $filesTree->each(function ($fileTree) {
            $fileTree->source = 'file';
        });
        // Gabungkan data folder dan file
        $combinedData = $parentFolders->concat($filesTree);

        $currentPath = $slug;
        return view('home.home', compact('combinedData', 'combinedDataTable', 'dataSlug', 'folderNames', 'currentPath', 'openedFolder'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFolderRequest $request)
    {
        $name = $request->name;
        $parentFolder = "Root Folder";

        // Menginisialisasi iterasi dengan 0
        $iteration = 0;
        $originalName = $name;

        // Melakukan loop hingga menemukan nama unik
        while (Storage::disk('public')->exists($parentFolder . '/' . $name)) {
            // Nama folder sudah ada, tambahkan iterasi ke nama
            $iteration++;
            $name = $originalName . ' (' . $iteration . ')';
        }

        $path = $parentFolder . '/' . $name;

        Storage::disk('public')->makeDirectory($path);

        Folder::create([
            'name'     => $name,
            'folder_path' => $path,
            'dept_id'  => $request->dept_id,
            'user_id'  => auth()->user()->id,
        ]);

        return redirect()->back()->with('primary', 'Successfully Created Folder.');
    }

    public function nestedStoreFolder(StoreFolderRequest $request, $slug)
    {
        // Pisahkan slug untuk membentuk array berdasarkan '/'
        $dataSlug = explode('/', $slug);
        // Ambil data terakhir dari array slug
        $lastIndex = count($dataSlug) - 1;
        // Ambil data folder berdasarkan slug terakhir
        $folder = Folder::with('department', 'childFolders')->where('slug', $dataSlug[$lastIndex])->first();

        $name = $request->name;
        // Mendapatkan hierarki folder dalam penyimpanan berdasarkan slug
        $parentFolder = "Root Folder"; // Gantilah dengan direktori penyimpanan yang sesuai

        foreach ($dataSlug as $data) {
            // Cari folder berdasarkan slug
            $folder = Folder::where('slug', $data)->first();

            if ($folder) {
                // Jika folder ditemukan, tambahkan nama folder ke hierarki penyimpanan
                $parentFolder .= '/' . $folder->name;
            } else {
                // Jika folder tidak ditemukan, tambahkan slug ke hierarki penyimpanan
                $parentFolder .= '/' . $data;
            }
        }

        // Menginisialisasi iterasi dengan 0
        $iteration = 0;
        $originalName = $name;

        // Melakukan loop hingga menemukan nama unik
        while (Storage::disk('public')->exists($parentFolder . '/' . $name)) {
            // Nama folder sudah ada, tambahkan iterasi ke nama
            $iteration++;
            $name = $originalName . ' (' . $iteration . ')';
        }
        
        $path = $parentFolder . '/' . $name;

        // Membuat direktori dengan menggunakan Storage
        Storage::disk('public')->makeDirectory($path);

        // Menyimpan data folder ke database
        Folder::create([
            'name'     => $name,
            'folder_path' => $path,
            'folder_id' => $folder->id,
            'dept_id'  => $folder->dept_id,
            'user_id'  => auth()->user()->id,
        ]);

        return redirect()->back()->with('primary', 'Successfully Created Folder.');
    }


    /**
     * Update the specified resource in storage.
     *  
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateFolderRequest $request, $slug)
    {
        // Pisahkan slug untuk membentuk array berdasarkan '/'
        $dataSlug = explode('/', $slug);
        // Ambil data terakhir dari array slug
        $lastIndex = count($dataSlug) - 1;

        // Ambil data folder berdasarkan slug terakhir
        $targetFolder = Folder::where('slug', $dataSlug[$lastIndex])->firstOrFail();

        if ($targetFolder->name === $request->name) {
            return redirect()->back()->with('warning', 'No data changes.');
        }

        // Apakah folder yang dituju memiliki parent folder?
        if ($targetFolder->folder_id != null) {
            // Simpan nama folder yang baru untuk mengonstruksi path penyimpanan yang baru
            $newFolderPath = "Root Folder"; // Gantilah dengan direktori penyimpanan yang sesuai

            foreach ($dataSlug as $data) {
                // Cari folder berdasarkan slug
                $folder = Folder::where('slug', $data)->first();

                if ($folder) {
                    // Jika folder ditemukan, tambahkan nama folder yang baru ke hierarki penyimpanan yang baru
                    $newFolderPath .= '/' . $folder->name;
                    // Jika parent folder yang ditemukan adalah parent folder dari folder yang dituju
                    if ($folder->id === $targetFolder->folder_id) {
                        // Tambahkan juga nama folder yang baru
                        $newFolderPath .= '/' . $request->name;
                        //stop loop
                        break;
                    }
                } else {
                    // Jika folder tidak ditemukan, tambahkan slug ke hierarki penyimpanan yang baru
                    $newFolderPath .= '/' . $data;
                }
            }
        } else {
            $newFolderPath = "Root Folder" . '/' . $request->name;
        }

        // Ambil semua file dengan path seperti folder
        $getAllFiles = File::where('file_path', 'like', $targetFolder->folder_path . '%')->get();
        foreach ($getAllFiles as $file) {
            // Mendapatkan path file lama
            $oldFilePath = $file->file_path;

            // Mendapatkan path file baru (mengganti nama folder saja)
            $newFilePath = str_replace($targetFolder->folder_path, $newFolderPath, $oldFilePath);
            // Update path file di database
            $file->file_path = $newFilePath;
            $file->file_link = Storage::url($newFilePath);
            $file->update();
        }

        $getAllFolder = Folder::where('folder_path', 'like', $targetFolder->folder_path . '%')->get();
        foreach ($getAllFolder as $folder) {
            // Mendapatkan path folder lama
            if ($folder->id != $targetFolder->id) {
                $oldFolderPath = $folder->folder_path;

                // Mendapatkan path folder baru (mengganti nama folder saja)
                $newParentPath = str_replace($targetFolder->folder_path, $newFolderPath, $oldFolderPath);
                // Update path folder di database
                $folder->folder_path = $newParentPath;
                $folder->update();
            }
        }

        $currentPath = $targetFolder->folder_path;
        // Ubah nama direktori penyimpanan sesuai dengan hierarki folder yang diperbarui
        Storage::disk('public')->move($currentPath, $newFolderPath);

        // Update nama folder di database
        $targetFolder->name = $request->name;
        $targetFolder->folder_path = $newFolderPath;
        $targetFolder->update();

        return redirect()->back()->with('success', 'Successfully changed the folder name.');
    }
}
