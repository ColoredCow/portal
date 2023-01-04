<?php

namespace Modules\User\Services;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
// use Modules\User\Http\Requests\RoleRequest;

class RoleService
{
    public function addRoles($role = [])
    {
        $roleName = $role['name'];
        Role::create([
            'name' => $roleName,
            'label' => Str::title($roleName),
            'guard_name' => $role['guard_name'],
            'description' => $role['description']
        ]);
    }
}
