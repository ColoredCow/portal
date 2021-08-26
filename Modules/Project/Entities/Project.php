<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Client\Entities\Client;
use Modules\EffortTracking\Entities\Task;
use Modules\User\Entities\User;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectRepository;

class Project extends Model
{
    protected $guarded = [];

    protected $dates = ['start_date', 'end_date'];

    public function resources()
    {
        return $this->belongsToMany(User::class, 'project_resources', 'project_id', 'resource_id')
            ->withPivot('designation')->withTimestamps();
    }
    
	public function repositories() {
		return $this->hasMany( ProjectRepository::class );
	}

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
