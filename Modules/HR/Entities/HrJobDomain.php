<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HR\Database\Migrations\CreateHrJobDomainsTable;

class HrJobDomain extends Model
{
    protected $table = 'hr_job_domains';
    protected $primaryKey = 'hr_job_domains_id';
}
