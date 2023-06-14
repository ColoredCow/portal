<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'user_id',
        'contract_name',
        'contract_link'
    ];
}
