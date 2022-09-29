<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;
use Modules\User\Http\Requests\RoleRequest;
use Modules\User\services\RoleService;
use Spatie\Permission\Models\Permission;

class RolesController extends ModuleBaseController
{
    protected $service;

    public function __construct(RoleService $service)
    {
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
