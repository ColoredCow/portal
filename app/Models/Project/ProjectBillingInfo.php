<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectBillingInfo extends Model
{
    protected $table = 'project_billing_info';
    protected $fillable = ['project_id',  'contact_person_name', 'contact_person_email', 'other_members_to_cc', 'address', 'state_id', 'city', 'pincode', 'gst_number'];
    
}
