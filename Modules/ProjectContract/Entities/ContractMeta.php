<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class ContractMeta extends Model
{
    protected $table = 'contract_meta';

    protected $fillable = [
        'contract_id',
        'key',
        'value'
    ];
}
