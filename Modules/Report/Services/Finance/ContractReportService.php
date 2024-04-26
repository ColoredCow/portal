<?php

namespace Modules\Report\Services\Finance;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Client\Entities\Client;
use Modules\HR\Entities\Employee;
use Modules\Project\Contracts\ProjectServiceContract;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectBillingDetail;
use Modules\Project\Entities\ProjectContract;
use Modules\Project\Entities\ProjectMeta;
use Modules\Project\Entities\ProjectRepository;
use Modules\Project\Entities\ProjectResourceRequirement;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectTeamMembersEffort;
use Modules\Project\Exports\ProjectFTEExport;
use Modules\User\Entities\User;



class ContractReportService implements ProjectServiceContract
{
    public function getAllProjectsData()
    {
            

            $ClientData = Client::query()
            ->with('projects')
            ->whereHas('projects')
            ->orderBy('name')
            ->paginate(config('constants.pagination_size'));

            
            
            return $ClientData;
    }    
}













// $projectsData = Client::query()
//             ->with('projects', $projectClauseClosure)
//             ->whereHas('projects', $projectClauseClosure)
//             ->orderBy('name')
//             ->paginate(config('constants.pagination_size'));
