<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends ModuleBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('user::roles.index', compact('roles', 'permissions'));
    }

    public function getAllRoles()
    {
        return Role::all();
    }
}
