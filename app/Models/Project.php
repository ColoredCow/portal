<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    $fillable = ['name', 'client_id', 'project_client_id', 'started_on', 'invoice_email', 'status'];

    /**
     * The clients that belong to the project.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
