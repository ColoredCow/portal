<?php

namespace Modules\HR\Services;

use Modules\HR\Entities\University;
use Modules\HR\Contracts\UniversityServiceContract;

class UniversityService implements UniversityServiceContract
{
    public function list($filteredString=false)
    {
        if (!$filteredString) {
            return University::latest()->paginate(config('constants.pagination_size'));
        }
        return University::filter(['name'], $filteredString)->orFilter(['address'], $filteredString)
        ->orWhereHas('universityContacts', function ($query) use ($filteredString) {
            $query->filter(['name'], $filteredString)->orFilter(['email','designation','phone'], $filteredString);
        })->latest()->paginate(config('constants.pagination_size'));
    }
}
