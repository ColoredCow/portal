<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Project\Database\Factories\ProjectTeamMemberFactory;

class ProjectTeamMember extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        /* @phpstan-ignore-next-line */
        return new ProjectTeamMemberFactory();
    }
}
