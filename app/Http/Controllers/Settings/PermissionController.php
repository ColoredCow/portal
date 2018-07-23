<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRolePermissionsRequest;
use App\Http\Requests\UpdateUserRolesRequest;
use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(String $module)
    {
        $attr = [];
        if ($module === 'users') {
            $attr['users'] = User::with('roles')->get();
            $attr['roles'] = Role::all();
            return view('settings.permissions.users')->with($attr);
        }
        $attr['roles'] = Role::with('permissions')->get();
        $attr['permissions'] = Permission::all();
        return view('settings.permissions.roles')->with($attr);
    }

    public function updateUserRoles(UpdateUserRolesRequest $request)
    {
        $validatedData = $request->validated();
        if (!isset($validatedData['roles'])) {
            return response()->json([
                'isUpdated' => false,
            ]);
        }
        $user = User::find($validatedData['userID']);
        $roles = array_pluck($validatedData['roles'], 'id');
        $isUpdated = $user->syncRoles($roles);
        return response()->json(['isUpdated' => $isUpdated]);
    }

    public function updateRolePermissions(UpdateRolePermissionsRequest $request)
    {
        $validatedData = $request->validated();
        if (!isset($validatedData['permissions'])) {
            return response()->json([
                'isUpdated' => false,
            ]);
        }
        $role = Role::find($validatedData['roleID']);
        $permissions = array_pluck($validatedData['permissions'], 'id');
        $isUpdated = $role->syncPermissions($permissions);
        return response()->json(['isUpdated' => $isUpdated]);
    }

}
