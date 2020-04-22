<?php

namespace Modules\Project\Entities;

use Modules\User\Entities\User;
use Modules\Client\Entities\Client;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    protected $dates = ['start_date', 'end_date'];

    public function resources()
    {
        return $this->belongsToMany(User::class, 'project_resource', 'project_id', 'resource_id')
        ->withPivot('designation')->withTimestamps();
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
