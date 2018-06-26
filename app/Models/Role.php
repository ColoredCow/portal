<?php

namespace App\Models;

use App\Models\IsTenantModel;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use IsTenantModel;
}
