<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\DomainService;

class Domain extends Facade
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
        return DomainService::class;
    }
}
