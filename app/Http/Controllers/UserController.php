<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Permission;
use Carbon\Carbon;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('role', 'department', 'permissions')->get();

        $permissions = Permission::all();

        // Tampilkan view index dengan data user yang di pagination dan data permission
        return view('dashboard.admin.user.index', compact('users', 'permissions'));
    }

    public function permissions(Request $request)
    {
        // Simpan inputan search dari inputan user
        $search = $request->get('search');

        // Query data user dengan relasi role, department, dan permissions
        $query = User::with('role', 'department', 'permissions');

        // Jika $search berisi data, maka lakukan pencarian data berdasarkan inputan user
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('nip', 'like', '%' . $search . '%')
                ->orWhereHas('role', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('department', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('permissions', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });

            // Pencarian berdasarkan tanggal dan waktu pada kolom created_at
            if (strtotime($search)) {
                $searchDate = Carbon::parse($search)->translatedFormat('Y/m/d');
                $query->orWhereDate('created_at', $searchDate);
            }
        }

        // Pagination data user
        $users = $query->paginate(10);

        // Ambil semua data permission
        $permissions = Permission::all();

        // Ambil nomor halaman sebelumnya dari query string
        $prevPage = $request->input('page', 1);

        // Tampilkan view index dengan data user yang di pagination dan data permission
        return view('dashboard.admin.user.user_permission', compact('users', 'permissions', 'prevPage'));
    }

    public function updatePermissions(Request $request)
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

        // Ambil nomor halaman sebelumnya dari query string
        $backToPage = $request->input('page', 1);

        // Redirect ke halaman daftar user sesuai dengan page sebelumnya dengan pesan sukses
        return redirect()->route('user.index', ['page' => $backToPage])->with('success', 'Hak Akses Berhasil Diubah.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Ambil semua data role, department, dan permission
        $roles = Role::all();
        $departments = Department::orderBy('name', 'asc')->get();
        $permissions = Permission::all();

        // Tampilkan halaman tambah user dengan data user, role, department, dan permission
        return view('dashboard.admin.user.create', compact('permissions', 'roles', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        // Buat data user baru di database
        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'dept_id' => $request->dept_id,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password)
        ]);

        // Jika user memiliki permission, maka tambahkan permission dan simpan ke tabel permission_user
        if ($request->has('permission')) {
            $permissions = $request->input('permission');
            $user->permissions()->attach($permissions);
        }

        // Redirect ke halaman daftar user sesuai dengan page sebelumnya dengan pesan sukses
        return redirect()->route('user.index')->with('primary', 'Successfully Added Data.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        // Ambil data user berdasarkan id
        $user = User::findOrFail($user->id);

        // Ambil semua data role, department, dan permission
        $roles = Role::all();
        $departments = Department::orderBy('name', 'asc')->get();
        $permissions = Permission::all();

        // Tampilkan halaman edit user dengan data user, role, department, dan permission
        return view('dashboard.admin.user.edit', compact('user', 'permissions', 'roles', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Ambil data user berdasarkan id
        $user = User::findOrFail($user->id);

        if ($request->password != null) {
            $data = [
                'name' => $request->name,
                'nip' => $request->nip,
                'email' => $request->email,
                'dept_id' => $request->dept_id,
                'role_id' => $request->role_id,
                'password' => Hash::make($request->password),
            ];
        } else {
            $data = [
                'name' => $request->name,
                'nip' => $request->nip,
                'email' => $request->email,
                'dept_id' => $request->dept_id,
                'role_id' => $request->role_id,
            ];
        }
        
        // Update data user ke dalam database sesuai dengan $data
        $user->update($data);

        // Jika user memiliki permission, 
        // Maka tambahkan permission dan simpan ke tabel permission_user
        if ($request->has('permissions')) {
            $permissions = $request->input('permissions');
            $user->permissions()->sync($permissions);
        } else {
            $user->permissions()->detach();
        }

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Successfully changed data.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Detach semua permission yang dimiliki user
        $user->permissions()->detach();
        // Hapus user dari database
        $user->delete();

        return redirect()->route('user.index')->with('danger', 'Successfully deleted data.');
    }
}
