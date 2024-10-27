<?php
namespace Modules\HR\Services;

use Modules\HR\Contracts\UniversityServiceContract;
use Modules\HR\Entities\University;

class UniversityService implements UniversityServiceContract
{
    public function list($filteredString = false)
    {
        if (! $filteredString) {
            return University::select('hr_universities.*')
            ->leftJoin('hr_applicants', 'hr_universities.id', '=', 'hr_applicants.hr_university_id')
            ->orderByRaw('COUNT(hr_applicants.hr_university_id) DESC')
            ->groupBy('hr_universities.id')
            ->paginate(config('constants.pagination_size'));
        }

        return University::filter(['name'], $filteredString)->orFilter(['address'], $filteredString)
        ->orWhereHas('universityContacts', function ($query) use ($filteredString) {
            $query->filter(['name'], $filteredString)->orFilter(['email', 'designation', 'phone'], $filteredString);
        })->latest()->paginate(config('constants.pagination_size'));
    }
}
