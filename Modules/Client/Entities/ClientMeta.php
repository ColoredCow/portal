<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Model;

class ClientMeta extends Model
{
    protected $table = 'client_meta';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}