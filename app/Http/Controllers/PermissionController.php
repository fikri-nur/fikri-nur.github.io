<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions  = Permission::all();
        return view('dashboard.admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
        ]);

        return redirect()->route('permission.index')->with('primary', 'Successfully Added Data.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission = Permission::findOrFail($permission->id);

        if ($permission->name == 'Create Folder') {
            return redirect()->route('permission.index')->with('danger', "Unable to change data.");
        }

        if ($permission->name == 'Upload File') {
            return redirect()->route('permission.index')->with('danger', "Unable to change data.");
        }

        if ($permission->name == 'Edit Delete Folder') {
            return redirect()->route('permission.index')->with('danger', "Unable to change data.");
        }

        if ($permission->name == 'Edit Delete File') {
            return redirect()->route('permission.index')->with('danger', "Unable to change data.");
        }

        if ($permission->name == 'Open Folder') {
            return redirect()->route('permission.index')->with('danger', "Unable to change data.");
        }

        if ($permission->name == 'Open File') {
            return redirect()->route('permission.index')->with('danger', "Unable to change data.");
        }

        if ($permission->name === $request->name) {
            return redirect()->route('permission.index')->with('warning', 'No data changes.');
        }

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->route('permission.index')->with('success', 'Successfully changed data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if ($permission->name == 'Create Folder') {
            return redirect()->route('permission.index')->with('danger', "Unable to delete data.");
        }

        if ($permission->name == 'Upload File') {
            return redirect()->route('permission.index')->with('danger', "Unable to delete data.");
        }

        if ($permission->name == 'Edit Delete Folder') {
            return redirect()->route('permission.index')->with('danger', "Unable to delete data.");
        }

        if ($permission->name == 'Edit Delete File') {
            return redirect()->route('permission.index')->with('danger', "Unable to delete data.");
        }

        if ($permission->name == 'Open Folder') {
            return redirect()->route('permission.index')->with('danger', "Unable to delete data.");
        }

        if ($permission->name == 'Open File') {
            return redirect()->route('permission.index')->with('danger', "Unable to delete data.");
        }

        $permission->delete();

        return redirect()->route('permission.index')->with('danger', 'Successfully deleted data.');
    }
}
