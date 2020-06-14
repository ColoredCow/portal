<?php

namespace Modules\HR\Services;

use App\Models\HR\Applicant;
use Modules\HR\Contracts\ApplicationServiceContract;

class ApplicationService implements ApplicationServiceContract
{
    public function saveApplication($data) {
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        Applicant::_create($data);
        return true;
    }
}
