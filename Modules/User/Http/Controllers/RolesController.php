<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('user::roles.index', compact('roles', 'permissions'));
    }

    public function getAllRoles()
    {
        return Role::all();
    }
}
