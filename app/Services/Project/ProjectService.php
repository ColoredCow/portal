<?php

namespace App\Services\Project;

use App\Models\Project;
use App\Models\Project\ProjectBillingInfo;

class ProjectService
{

    public function create($data) {
        $project =  Project::create([
            'name' => $data['name'],
            'client_id' => $data['client_id'],
            'client_project_id' => $data['client_project_id'],
            'status' => $data['status'],
            'invoice_email' => $data['invoice_email'],
        ]);

        $project->billingInfo()->create($data);
        return $project;
    }
    
}
