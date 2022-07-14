<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Model;

class ClientEmailId extends Model
{
    protected $fillable = ['client_id', 'project_id', 'cc_emails', 'bcc_emails'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}