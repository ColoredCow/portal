<?php

namespace App\Services;

use App\Models\Organization;

class OrganizationService
{
    public function createOrganization($data)
    {
        Organization::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'annual_sales' => $data['annual_sales'],
            'members' => $data['members'],
            'industry' => $data['industry'],
            'email' => $data['email'],
            'billing_details' => $data['billing_details'],
            'website' => $data['website'],
        ]);
    }
}