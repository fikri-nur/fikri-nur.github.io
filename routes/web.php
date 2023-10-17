<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\FileController;
use App\Http\Controllers\Home\FolderController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role->name === 'Administrator') {
            return redirect()->route('dashboard');
        } elseif (Auth::user()->role->name === 'Superuser' || Auth::user()->role->name === 'User') {
            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::middleware(['role:Administrator'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class);

    Route::get('/user-permissions', [UserPermissionController::class, 'permissions'])->name('user-permissions');
    Route::post('/user-permissions/update', [UserPermissionController::class, 'updatePermissions'])->name('user-permissions.update');

    Route::resource('role', RoleController::class);

    Route::resource('department', DepartmentController::class);

    Route::resource('permission', PermissionController::class);
});

Route::middleware(['role:Administrator,Superuser,User'])->prefix('home')->group(function () {
    // Get home page (ok)
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => ['checkDepartment']], function () {
        // Route for opening file (ok)
        Route::get('/open/{file:slug}.{ext}', [FileController::class, 'laravelFileViewer'])->name('home.file.viewer');

        // Route for opening nested file (ok)
        Route::get('/{slug}/open/{file:slug}.{ext}', [FileController::class, 'nestedLaravelFileViewer'])
            ->where('slug', '.*')
            ->name('home.nested.file.viewer');

        // Route for storing files (upload files) (ok)
        Route::post('/store-files', [FileController::class, 'multipleStoreFile'])->name('home.files.store');

        // Route for nested storing files (upload files) (ok)
        Route::post('/{slug}/file-store', [FileController::class, 'nestedMultipleStoreFiles'])
            ->where('slug', '.*')
            ->name('home.nested.files.store');

        // Route for updating file (ok)
        Route::put('/{slug}/update/file', [FileController::class, 'update'])
            ->where('slug', '.*')
            ->name('home.file.update');

        // Route for downloading file (ok)
        Route::get('/download/{file:slug}.{ext}', [FileController::class, 'downloadFile'])->name('home.file.download');
    });

    Route::group(['middleware' => ['checkDepartment']], function () {
        // Nested route for folder (ok)
        Route::get('/{slug}', [FolderController::class, 'indexNestedFolder'])
            ->where('slug', '.*')
            ->name('home.folder.nested');

        // Route for storing folder (ok)
        Route::post('/store', [FolderController::class, 'store'])->name('home.store');

        // Route for nested store folder (ok)
        Route::post('/{slug}/store', [FolderController::class, 'nestedStoreFolder'])
            ->where('slug', '.*')
            ->name('home.nested.store');

        // Route for updating folder (ok)
        Route::put('/{slug}/update/folder', [FolderController::class, 'update'])
            ->where('slug', '.*')
            ->name('home.folder.update');

        // Route for destroying folder & file (ok)
        Route::delete('/{slug}/destroy/{source}', [HomeController::class, 'destroyFolderFile'])
            ->where('slug', '.*')
            ->name('home.destroy');
    });
});