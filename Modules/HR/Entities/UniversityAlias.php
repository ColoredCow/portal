<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrUniversityAliasesFactory;
use Modules\HR\Traits\HasFilters;

class UniversityAlias extends Model
{
    use HasFactory;
    use HasFilters;

    protected $fillable = ['hr_university_id', 'name'];

    protected $table = 'hr_university_aliases';

    public function university()
    {
        return $this->belongsTo(University::class, 'hr_university_id');
    }
    public static function newFactory()
    {
        return new HrUniversityAliasesFactory();
    }
}
