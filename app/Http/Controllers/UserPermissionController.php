<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    public function permissions(Request $request)
    {
        $users = User::with('role', 'department', 'permissions')->get();

        // Ambil semua data permission
        $permissions = Permission::all();

        // Tampilkan view index dengan data user yang di pagination dan data permission
        return view('dashboard.admin.user.user_permission', compact('users', 'permissions'));
    }

    public function updatePermissions(User $user, Request $request)
    {
        // Simpan inputan permissions dari inputan user
        $permissions_request = $request->input('permissions');

        // Jika $permissions_request berisi data, maka lakukan update data permission
        if ($permissions_request !== null) {
            // Looping data permissions untuk disimpan ke tabel pivot permission_user
            foreach ($permissions_request as $user_id => $permission_id) {
                $user = User::findOrFail($user_id);
                $user->permissions()->sync($permission_id);
            }
        }

        return redirect()->route('user.index')->with('success', 'User permissions have been successfully changed.');
    }
}
