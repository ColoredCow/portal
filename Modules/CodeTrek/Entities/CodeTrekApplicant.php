<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;

class CodeTrekApplicant extends Model
{
   protected $fillable=[
    'first_name','last_name','email','github_user_name','phone','course','start_date','graduation_year','university'
   ];
}
