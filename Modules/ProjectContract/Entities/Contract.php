<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'user_id',
        'contract_name',
        'contract_link',
        'status'
    ];

    public function contractMeta()
    {
        return $this->hasMany(ContractMeta::class, 'contract_id');
    }
    public function contractMetaHistory()
    {
        return $this->hasMany(ContractMetaHistory::class, 'contract_id');
    }
}
