<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('dashboard.admin.role.index', compact('roles'));
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
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('role.index')->with('primary', 'Successfully Added Data.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = Role::findOrFail($role->id);

        if ($role->name == 'Superadmin') {
            return redirect()->route('role.index')->with('danger', "Unable to change Superadmin data.");
        }

        if ($role->name == 'User') {
            return redirect()->route('role.index')->with('danger', "Unable to change User data.");
        }

        if ($role->name === $request->name) {
            return redirect()->route('role.index')->with('warning', 'No data changes.');
        }

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('role.index')->with('success', 'Successfully changed data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->name == 'Superadmin') {
            return redirect()->route('role.index')->with('danger', "Unable to delete Superadmin data.");
        }

        if ($role->name == 'User') {
            return redirect()->route('role.index')->with('danger', "Unable to delete User data.");
        }

        $role->delete();

        return redirect()->route('role.index')->with('danger', 'Successfully deleted data.');
    }
}
