<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;
use Modules\User\Http\Requests\RoleRequest;
use Modules\User\Services\RoleService;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RolesController extends ModuleBaseController
{
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

    public function storeRoles(RoleRequest $request)
    {
        $this->service->storeRoles($request);

        return redirect()->back();
    }

    public function DeleteRoles($id)
    {
        Role::find($id)->delete();

        return response()->json([
            'status'=>200,
            'message'=>'Role deleted successfuly'
        ]);
    }
}
