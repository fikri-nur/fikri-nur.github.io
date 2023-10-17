<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LaravelFileViewer\LaravelFileViewer;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkDepartment');
    }

    public function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }

    public function laravelFileViewer(File $file)
    {
        $filepath = $file->file_path;

        if (!Storage::disk('public')->exists($filepath)) {
            return redirect()->back()->with('danger', 'File tidak ditemukan');
        } else {
            $file_data = [
                [
                    'label' => __('Uploaded by'),
                    'value' => $file->user->name,
                ],
                [
                    'label' => __('Uploaded at'),
                    'value' => $file->formatted_created_at,
                ],
                [
                    'label' => __('Size'),
                    'value' => $file->formatted_size_unit,
                ],
                [
                    'label' => __('Extension'),
                    'value' => $file->ext,
                ],

            ];
            $laravelFileViewer = new LaravelFileViewer();
            return $laravelFileViewer->show($file, $file_data);
        }
    }

    public function nestedLaravelFileViewer($slug, File $file)
    {
        $filepath = $file->file_path;

        if (!Storage::disk('public')->exists($filepath)) {
            return redirect()->back()->with('danger', 'File tidak ditemukan');
        } else {
            $file_data = [
                [
                    'label' => __('Uploaded by'),
                    'value' => $file->user->name,
                ],
                [
                    'label' => __('Uploaded at'),
                    'value' => $file->formatted_created_at,
                ],
                [
                    'label' => __('Size'),
                    'value' => $file->formatted_size_unit,
                ],
                [
                    'label' => __('Extension'),
                    'value' => $file->ext,
                ],

            ];

            $laravelFileViewer = new LaravelFileViewer();
            return $laravelFileViewer->show($file, $file_data);
        }
    }

    public function multipleStoreFile(Request $request)
    {
        $uploadedFiles = $request->file('file');
        if (!empty($uploadedFiles)) {
            foreach ($uploadedFiles as $file) {
                // Mendapatkan informasi tentang file yang diupload
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $mime_type = $file->getClientMimeType();
                $original_size = $file->getSize();
                $formatted_size_unit = $this->formatBytes($original_size);

                $path = $file->storeAs("/Root Folder", $name . '_' . uniqid() . '.' . $ext, ['disk' => 'public']);
                $link = Storage::url($path);

                // Simpan informasi file ke dalam database
                File::create([
                    'name' => $name,
                    'mime_type' => $mime_type,
                    'ext' => $ext,
                    'original_size' => $original_size,
                    'formatted_size_unit' => $formatted_size_unit,
                    'user_id' => auth()->user()->id,
                    'file_path' => $path,
                    'file_link' => $link,
                ]);
            }
            // Redirect ke halaman daftar file
            return redirect()->back()->with('primary', 'Successfully Uploaded File.');
        } else {
            // Tidak ada file yang diunggah
            return redirect()->route('home')->with('danger', 'No file uploaded.');
        }
    }

    public function nestedMultipleStoreFiles(Request $request, $slug)
    {
        // Pisahkan slug untuk membentuk array berdasarkan '/'
        $dataSlug = explode('/', $slug);

        // Ambil data terakhir dari array slug
        $lastIndex = count($dataSlug) - 1;
        // Ambil data folder berdasarkan slug terakhir
        $folder = Folder::with('department', 'childFolders')->where('slug', $dataSlug[$lastIndex])->first();

        $uploadedFiles = $request->file('file');

        if (!empty($uploadedFiles)) {
            $slugToName = ''; // Inisialisasi variabel yang akan digunakan untuk menyimpan hasil

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
            $filePath = ltrim($slugToName, '/');

            foreach ($uploadedFiles as $file) {

                // Mendapatkan informasi tentang file yang diupload
                $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $mime_type = $file->getClientMimeType();
                $original_size = $file->getSize();
                $formatted_size_unit = $this->formatBytes($original_size);

                $path = $file->storeAs("/Root Folder/{$filePath}", $name . '_' . uniqid() . '.' . $ext, ['disk' => 'public']);
                $link = Storage::url($path);

                // Simpan informasi file ke dalam database
                File::create([
                    'name' => $name,
                    'mime_type' => $mime_type,
                    'ext' => $ext,
                    'original_size' => $original_size,
                    'formatted_size_unit' => $formatted_size_unit,
                    'user_id' => auth()->user()->id,
                    'file_path' => $path,
                    'file_link' => $link,
                    'dept_id'   => $folder->dept_id,
                    'parent_folder_id' => $folder->id,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'File Uploaded Successfully',
            ], 200);
        } else {
            // Tidak ada file yang diunggah
            return response()->json([
                'success' => false,
                'message' => 'No file uploaded.',
            ], 400);
        }
    }

    public function update(UpdateFileRequest $request, $slug)
    {
        $newName = $request->name;
        $dataSlug = explode('/', $slug);

        if (count($dataSlug) > 1) {
            $lastIndex = count($dataSlug) - 1;
            $targetFolder = Folder::where('slug', $dataSlug[$lastIndex - 1])->firstOrFail();
            $targetFile = File::where('slug', $dataSlug[$lastIndex])->firstOrFail();
        } else {
            $targetFolder = "Root Folder";
            $targetFile = File::where('slug', $dataSlug[0])->firstOrFail();
        }

        if ($targetFile->name === $newName) {
            return redirect()->back()->with('warning', 'No data changes.');
        }

        if ($targetFolder !== "Root Folder") {
            $newFilePath = $targetFolder->folder_path . '/' . $newName . '_' . uniqid() . '.' . $targetFile->ext;
        } else {
            $newFilePath = $targetFolder . '/' . $newName . '_' . uniqid() . '.' . $targetFile->ext;
        }

        $oldFilePath = $targetFile->file_path;
        Storage::disk('public')->move($oldFilePath, $newFilePath);

        // Update nama file di database
        $targetFile->name = $newName;
        $targetFile->file_path = $newFilePath;
        $targetFile->file_link = Storage::url($newFilePath);
        $targetFile->update();

        return redirect()->back()->with('success', 'Successfully changed the file name.');
    }

    public function downloadFile(File $file)
    {
        $filepath = $file->file_path;
        $filelink = $file->file_link;

        if (!Storage::disk('public')->exists($filepath)) {
            return redirect()->back()->with('danger', 'File tidak ditemukan');
        } else {
            // Download file
            return response()->download(public_path($filelink), $file->name . '.' . $file->ext);
        }
    }
}
