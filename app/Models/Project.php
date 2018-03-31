<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    $fillable = ['name', 'started_on', 'invoice_email', 'status'];

    /**
     * The clients that belong to the project.
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}
