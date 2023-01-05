<?php

namespace Modules\User\Services;

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
