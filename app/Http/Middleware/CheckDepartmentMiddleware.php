<?php

namespace App\Http\Middleware;

use App\Models\File;
use App\Models\Folder;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDepartmentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->route('file') != null) {
            $file = $request->route('file'); // Ambil slug dari parameter rute
            // Periksa apakah pengguna memiliki akses ke file berdasarkan departemen
            if (Auth::user()->dept_id == $file->dept_id || Auth::user()->role->name == 'Administrator' || $file->dept_id == null || auth()->user()->role->name == 'Superuser') {
                return $next($request); // Lanjutkan ke rute yang diminta
            } else {
                // Jika pengguna tidak memiliki peran yang diizinkan, redirect ke halaman lain atau tampilkan pesan error
                return redirect()->back()->with('danger', 'You do not have access to the folder or file.');
            }
        } elseif ($request->route('slug') != null) {
            $slug = $request->route('slug'); // Ambil slug dari parameter rute

            // Pisahkan slug untuk membentuk array berdasarkan '/'
            $dataSlug = explode('/', $slug);
            // Ambil data terakhir dari array slug
            $lastIndex = count($dataSlug) - 1;

            $targetFolder = Folder::where('slug', $dataSlug[$lastIndex])->first();
            $targetFile = File::where('slug', $dataSlug[$lastIndex])->first();
            if ($targetFolder != null) {
                // Ambil data folder berdasarkan slug terakhir
                $targetFolder = Folder::where('slug', $dataSlug[$lastIndex])->firstOrFail();
                // Periksa apakah pengguna memiliki akses ke folder berdasarkan departemen
                if (Auth::user()->dept_id == $targetFolder->dept_id || Auth::user()->role->name == 'Administrator' || $targetFolder->dept_id == null || auth()->user()->role->name == 'Superuser') {
                    return $next($request); // Lanjutkan ke rute yang diminta
                } else {
                    // Jika pengguna tidak memiliki peran yang diizinkan, redirect ke halaman lain atau tampilkan pesan error
                    return redirect()->back()->with('danger', 'You do not have access to the folder or file.');
                }
            } elseif ($targetFile != null) {
                // Ambil data file berdasarkan slug terakhir
                $targetFile = File::where('slug', $dataSlug[$lastIndex])->firstOrFail();

                // Periksa apakah pengguna memiliki akses ke file berdasarkan departemen
                if (Auth::user()->dept_id == $targetFile->dept_id || Auth::user()->role->name == 'Administrator' || $targetFile->dept_id == null || auth()->user()->role->name == 'Superuser') {
                    return $next($request); // Lanjutkan ke rute yang diminta
                } else {
                    // Jika pengguna tidak memiliki peran yang diizinkan, redirect ke halaman lain atau tampilkan pesan error
                    return redirect()->back()->with('danger', 'You do not have access to the folder or file.');
                }
            } else {
                // Jika pengguna tidak memiliki peran yang diizinkan, redirect ke halaman lain atau tampilkan pesan error
                return redirect()->back()->with('danger', 'You do not have access to the folder or file.');
            }
        } else {
            // Periksa nama rute atau URL saat ini
            $routeName = $request->route()->getName();
            $currentUrl = $request->url();

            if ($routeName == 'home.files.store' || $currentUrl == 'home/store-files' || $routeName = 'home.store' || $currentUrl == 'home/store') {
                return $next($request); // Lanjutkan ke rute yang diperbolehkan
            } else {
                return redirect()->back()->with('danger', 'You do not have access to the folder or file.');
            }
        }
    }
}
