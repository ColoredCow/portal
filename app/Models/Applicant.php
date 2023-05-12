<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    protected $table = 'code_trek_applicants';

    protected $fillable = [

        'first_name',
        'last_name',
        'email',
        'github_user_name',
        'phone',
        'course',
        'start_date',
        'graduation_year',
        'university',
    ];
}
