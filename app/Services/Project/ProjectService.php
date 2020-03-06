<?php

namespace App\Services\Project;

use App\Models\Project;
use App\Models\Project\ProjectBillingInfo;

class ProjectService
{

    protected $project =  null;

    public function setProject($project) {
        $this->project = $project;
    }
    
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


    public function update($data) {
       $updated =  $this->project->update([
            'name' => $data['name'],
            'client_id' => $data['client_id'],
            'client_project_id' => $data['client_project_id'],
            'status' => $data['status'],
            'invoice_email' => $data['invoice_email'],
            'gst_applicable' => isset($data['gst_applicable']) ? true : false,
        ]);

        $billingInfo = $this->project->billingInfo;
        $billingInfo->fill($data);
        $billingInfo->update();
        
        // $this->project->billingInfo()->update($data);
         return $updated;
    }
    
}
