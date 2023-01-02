<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\User\Http\Requests\roleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\User\Services\addRoleModel;

class RolesController extends ModuleBaseController
{
    /*
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    protected $service;

    public function __construct(addRoleModel $service)
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
    public function addRoles(roleRequest $request)
    {
        $this->service->addRoles($request);

        return redirect()->back();
    }

    public function deleteRoles($id)
    {
        Role::find($id)->delete();
    }
}
