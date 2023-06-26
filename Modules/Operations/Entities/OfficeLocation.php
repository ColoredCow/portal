<?php

namespace Modules\Operations\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class OfficeLocation extends Model
{
    protected $guarded = [];

    public function centre_head()
    {
        return $this->belongsTo(User::class, 'centre_head_id');
    }
}
