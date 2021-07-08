<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\UniversityAlias;
use Modules\HR\Entities\UniversityContact;
use Modules\HR\Traits\HasFilters;

class University extends Model
{
    use HasFilters;

    protected $fillable = ['name','address','rating'];

    protected $table = 'hr_universities';

    public function universityContacts()
    {
        return $this->hasMany(UniversityContact::class, 'hr_university_id');
    }

    public function aliases()
    {
        return $this->hasMany(UniversityAlias::class, 'hr_university_id');
    }
}
