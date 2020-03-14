<?php

namespace App\Services\Finance;

use App\Models\Finance\AMC;

class AMCService
{
    public function create($data)
    {
        return AMC::create([
            'client_id' => $data['client_id'] ?? null , 
            'project_id' => $data['project_id'] ?? null ,  
            'started_at' => $data['started_at'] ?? null ,  
            'payment_cycle' => $data['payment_cycle'] ?? null ,  
            'per_hour_charges' => $data['per_hour_charges'] ?? null ,  
            'alloted_hours' => $data['alloted_hours'] ?? null ,  
            'extra_hours' => $data['extra_hours'] ?? null ,  
            'effort_sheet_link' => $data['effort_sheet_link'] ?? null , 
        ]);
    }
}
