<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use App\Models\HR\University;

class UniversityContact extends Model
{
    //
    protected $fillable = ['hr_university_id','name','designation','email','phone'];
    
    protected $table = 'hr_universities_contacts';

    public function university()
    {
        return $this->belongsTo(University::class, 'hr_university_id');
    }
}
