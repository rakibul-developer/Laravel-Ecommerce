<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    // show All Roles
    public function indexRole(){
        $roles = Role::whereNotIn('name', ['super-admin'])->orderBy('id', 'desc')->get();
        return view('backend.permission.index', compact('roles'));
    }

    // Create Roles
    public function createRole()
    {
        $permissions = Permission::all();
        return  view('backend.permission.create', compact('permissions'));
    }

    // Insert Roles
    public function insertRole(Request $request){
        $request->validate([
            'name' => 'required',
            'permission' => 'required'
        ]);
        $role = Role::create([
            'name' => $request->name
        ]);
        $role->givePermissionTo($request->permission);
        return redirect(route('backend.role.index'))->with('success', 'New Role Created');
    }

    // Insert Permission
    public function insertPermission(Request $request){
        $request->validate([
            'name' => 'required'
        ]);
        Permission::create([
            'name' => $request->name
        ]);
        return back();
    }

    // Edit Role
    public function editRole($id){
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return  view('backend.permission.edit', compact('permissions', 'role'));
    }

    // Update Role
    public function updateRole(Request $request, $id){
        $role = Role::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'permission' => 'required'
        ]);
        $role->update([
            'name' => $request->name
        ]);
        $role->syncPermissions($request->permission);
        return redirect(route('backend.role.index'))->with('success', 'Role Updated');
    }
}
