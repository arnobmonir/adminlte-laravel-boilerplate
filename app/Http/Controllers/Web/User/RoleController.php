<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Authorization\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Authorization\Permission;
use App\Models\Authorization\PermissionGroup;
use Exception;
use Toastr;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('role.show');
        $roles = Role::where('id', '>', 1)->get();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        //
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
    public function edit(Role $role)
    {
        $this->authorize('role.edit');
        $permissions_ids = Permission::permissionsRole($role);
        $groups = PermissionGroup::with('permissions')->get();
        return view('role.edit', compact('role', 'groups', 'permissions_ids'));
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
        $this->authorize('role.edit');
        if (!$role) {
            Toastr::warning('Permission not found!');
            return redirect()->route('admin.role.index');
        }
        $role->update($request->all());
        $permissions = $request->input('permissions') ? $request->input('permissions') : [];
        $role->permissions()->sync($permissions);
        Toastr::success('Permission successfully updated!');
        return redirect()->route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize('user.delete');
        try {
            $role->delete();
            Toastr::success("{$role->name} deleted successfully");
        } catch (Exception $ex) {
            Toastr::success("Failed: {$ex->getMessage()}");
        }

        return redirect()->back();
    }
}
