<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\TenantService;

class Tenant extends Facade
{
    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        //
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TenantService::class;
    }
}
