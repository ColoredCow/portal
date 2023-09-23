<?php

namespace Modules\ContractSettings\Entities;

use Illuminate\Database\Eloquent\Model;

class ContractSettings extends Model
{
    protected $fillable = [
        'id', 'contract_type', 'contract_template'
    ];
}
