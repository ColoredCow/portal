<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Entities\Client;
use Modules\EffortTracking\Entities\Task;
use Modules\Project\Database\factories\ProjectFactory;
use Modules\User\Entities\User;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start_date', 'end_date'];

    protected static function newFactory()
    {
        /* @phpstan-ignore-next-line */
        return new ProjectFactory();
    }

    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'project_team_members', 'project_id', 'team_member_id')
            ->withPivot('designation')->withTimestamps();
    }

    public function repositories()
    {
        return $this->hasMany(ProjectRepository::class);
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
