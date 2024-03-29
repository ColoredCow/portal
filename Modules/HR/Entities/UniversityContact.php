<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrUniversitiesContactsFactory;
use Modules\HR\Traits\HasFilters;

class UniversityContact extends Model
{
    use HasFactory;
    use HasFilters;

    protected $fillable = ['hr_university_id', 'name', 'designation', 'email', 'phone'];

    protected $table = 'hr_universities_contacts';

    public function university()
    {
        return $this->belongsTo(University::class, 'hr_university_id');
    }
    public static function newFactory()
    {
        return new HrUniversitiesContactsFactory();
    }
}
