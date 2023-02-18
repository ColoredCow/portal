<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;
use Modules\User\Http\Requests\RoleRequest;
use Modules\User\Services\RoleService;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RolesController extends ModuleBaseController
{
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
    public function storeRoles(RoleRequest $request)
    {
        $this->service->storeRoles($request);
    public function addRole(RoleRequest $request)
    {
        $this->authorize('viewAny', User::class);
        $validated = $request->validated();
        $this->service->addRole($validated);

        return redirect()->back();
    }
    public function DeleteRoles($id)
    {
        Role::find($id)->delete();

        return response()->json([
            'status'=>200,
            'message'=>'Role deleted successfuly'
        ]);
    public function deleteRole(Role $role)
    {
        $role->delete();
    }
}
