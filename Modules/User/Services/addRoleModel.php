<?php

namespace Modules\User\Services;

use Spatie\Permission\Models\Role;
use Modules\User\Http\Requests\roleRequest;

class addRoleModel
{
    /**
     * Display a listing of the resource.
     */
    public function addRoles(roleRequest $request)
    {
        $Role = new Role;
        $Role->name = $request->name;
        $Role->label = $request->label;
        $Role->guard_name = $request->guard_name;
        $Role->description = $request->description;
        $Role->save();
    }
}
