<?php

namespace App\Models;

use App\Models\IsTenantModel;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use IsTenantModel;
}
