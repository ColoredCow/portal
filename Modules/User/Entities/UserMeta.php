<?php

namespace Modules\User\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserMeta extends Model
{
    protected $table = 'user_meta';
    protected $fillable = ['max_interviews_per_day',];

    public function user()
    {
        return  $this->belongsTo (User::class);
    }

}