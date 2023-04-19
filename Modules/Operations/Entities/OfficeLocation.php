<?php

namespace Modules\operations\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class OfficeLocation extends Model
{
    protected $fillable = ['centre_name', 'centre_head_id', 'capacity', 'current_people_count'];

    public function centre_head()
    {
        return $this->belongsTo(User::class, 'centre_head_id');
    }
}
