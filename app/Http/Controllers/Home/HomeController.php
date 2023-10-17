<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request  $request)
    {
        $parentFolders = Folder::with('department', 'childFolders')->where('folder_id', '=', null)->orderby('name', 'asc')->get();

        $files = File::where('parent_folder_id', null)->orderby('name', 'asc')->get();

        // Tambahkan atribut 'source' ke setiap folder
        $parentFolders->each(function ($folder) {
            $folder->source = 'folder';
        });

        // Tambahkan atribut 'source' ke setiap file
        $files->each(function ($file) {
            $file->source = 'file';
        });

        // Gabungkan data folder dan file
        $combinedData = $parentFolders->concat($files);
        $combinedDataTable = $combinedData;

        $currentPath = null;
        $departments = Department::orderby('name', 'asc')->get();
        return view('home.home', compact('combinedData', 'combinedDataTable', 'currentPath', 'departments'));
    }

    public function destroyFolderFile($slug, $source)
    {
        // Pisahkan slug untuk membentuk array berdasarkan '/'
        $dataSlug = explode('/', $slug);
        // Ambil data terakhir dari array slug
        $lastIndex = count($dataSlug) - 1;

        if ($source === 'folder') {
            $parentFolder = Folder::where('slug', $dataSlug[$lastIndex])->firstOrFail();

            
            // delete folder
            $slugToName = 'Root Folder';
            
            foreach ($dataSlug as $data) {
                // Cari folder berdasarkan slug
                $folder = Folder::where('slug', $data)->first();
    
                if ($folder) {
                    // Jika folder ditemukan, tambahkan nama folder ke hasil yang sudah diformat
                    $slugToName .= '/' . $folder->name;
                } else {
                    // Jika folder tidak ditemukan, tambahkan slug ke hasil yang sudah diformat
                    $slugToName .= '/' . $data;
                }
            }
    
            // Jangan lupa menghilangkan garis miring awal jika ada
            $storagePath = ltrim($slugToName, '/');

            Storage::disk('public')->deleteDirectory($storagePath);
            $parentFolder->delete();
            return redirect()->back()->with('danger', 'The folder was successfully deleted.');

        } elseif ($source === 'file') {
            $file = File::where('slug', $dataSlug[$lastIndex])->firstOrFail();
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
            return redirect()->back()->with('danger', 'The file was successfully deleted.');
        }
    }
}
