<?php

namespace Modules\User\Services;

use Spatie\Permission\Models\Role;
use Modules\User\Http\Requests\RoleRequest;

class RoleService
{
    /**
     * Display a listing of the resource.
     */
    public function storeRoles(RoleRequest $request)
    {
        $Role = new Role;
        $Role->name = $request->name;
        $Role->label = $request->label;
        $Role->guard_name = $request->guard_name;
        $Role->description = $request->description;
        $Role->save();
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function addRole($roleData = [])
    {
        $roleName = $roleData['name'];
        Role::create([
            'name' => Str::slug($roleName),
            'label' => Str::title($roleName),
            'guard_name' => $roleData['guard_name'],
            'description' => $roleData['description'],
        ]);
    }
}
