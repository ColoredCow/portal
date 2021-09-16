<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'user_meta';
    protected $fillable = ['user_id', 'max_interviews_per_day'];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
