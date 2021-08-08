<?php

namespace App\Traits;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

trait ModuleBaseEntities
{
    use ValidatesRequests;
    use AuthorizesRequests {
        resourceAbilityMap as resourceAbilityMapTrait;
    }

    public function resourceAbilityMap()
    {
        // Map the "index" ability to the "index" function in our policies
        return array_merge($this->resourceAbilityMapTrait(), ['index' => 'index']);
    }
}
