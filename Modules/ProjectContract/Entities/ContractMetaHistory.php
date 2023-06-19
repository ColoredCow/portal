<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class ContractMetaHistory extends Model
{
    protected $table = 'contract_meta_history';

    protected $fillable = [
        'contract_id',
        'review_id',
        'key',
        'value'
    ];
}
