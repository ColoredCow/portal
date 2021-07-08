<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\University;
use Modules\HR\Traits\HasFilters;

class UniversityAlias extends Model
{
    use HasFilters;

    protected $fillable = ['hr_university_id', 'name'];

    protected $table = 'hr_university_aliases';

    public function university()
    {
        return $this->belongsTo(University::class, 'hr_university_id');
    }
}
