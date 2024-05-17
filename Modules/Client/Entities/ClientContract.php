<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Model;

class ClientContract extends Model
{
    protected $fillable = ['client_id', 'contract_file_path','start_date','end_date'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}