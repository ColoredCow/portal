<?php

namespace Modules\Operation\Services;

use Modules\Operation\Entities\OfficeLocation as OfficeLocation;
use Modules\User\Entities\User as User;

class OfficeLocationService
{
    public function index(array $data = [])
    {
        $users = User::all();
        $officeLocations = OfficeLocation::paginate('10')->withQueryString();

        return ['users' => $users, 'officeLocations' => $officeLocations];
    }

}
