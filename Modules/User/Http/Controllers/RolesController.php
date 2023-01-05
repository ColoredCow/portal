<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\RoleRequest;
use Modules\User\Services\RoleService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends ModuleBaseController
{
    /*
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    protected $service;

    public function __construct(RoleService $service)
    {
        $this->authorizeResource(Role::class);
        $this->service = $service;
    }

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

    public function addRole(RoleRequest $request)
    {
        $this->authorize('viewAny', User::class);
        $validated = $request->validated();
        $this->service->addRole($validated);

        return redirect()->back();
    }

    public function deleteRole(Role $role)
    {
		$role->delete();
    }
}
