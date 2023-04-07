<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrUniversitiesFactory;
use Modules\HR\Traits\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class University extends Model
{
    use HasFactory;
    use HasFilters;

    protected $fillable = ['name', 'address', 'rating'];

    protected $table = 'hr_universities';

    public function universityContacts()
    {
        return $this->hasMany(UniversityContact::class, 'hr_university_id');
    }

    public function aliases()
    {
        return $this->hasMany(UniversityAlias::class, 'hr_university_id');
    }
    public static function newFactory()
    {
        return new HrUniversitiesFactory();
    }
}
