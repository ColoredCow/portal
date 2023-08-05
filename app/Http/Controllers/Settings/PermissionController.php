<?php

namespace App\Http\Controllers\Settings;

use App\Models\Setting;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Setting\UpdateUserRolesRequest;
use App\Http\Requests\Setting\UpdateRolePermissionsRequest;

class PermissionController extends Controller
{
    public function index(string $module)
    {
        $this->authorize('settings.view', Permission::class);
        $attr = [];
        switch ($module) {
            case 'users':
                $attr['users'] = User::orderBy('name')->with('roles')->get();
                $attr['roles'] = Role::all();
                break;
            default:
                $attr['roles'] = Role::with('permissions')->get();
                $attr['permissions'] = Permission::all();
                break;
        }
        $attr['settings'] = Setting::where('module', $module)->get()->keyBy('setting_key');

        return view("settings.permissions.$module")->with($attr);
    }

    public function updateUserRoles(UpdateUserRolesRequest $request)
    {
        $this->authorize('settings.update', Permission::class);
        $validatedData = $request->validated();
        if (! isset($validatedData['roles'])) {
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
        $this->authorize('settings.update', Permission::class);
        $validatedData = $request->validated();
        if (! isset($validatedData['permissions'])) {
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
