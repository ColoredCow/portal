<?php

namespace App\Models\Finance;

use App\Models\Project;
use App\Models\ProjectStageBilling;
use Illuminate\Database\Eloquent\Model;

class AMC extends Model
{
    protected $guarded = [];
    protected $table= 'finance_amcs';

    public function project() {
        return $this->belongsTo(Project::class);
    }

}
