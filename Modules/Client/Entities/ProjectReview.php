<?php

namespace Modules\Client\Entities;
use Modules\Client\Entities\Client;
use Modules\User\Entities\User;

use Illuminate\Database\Eloquent\Model;

class ProjectReview extends Model
{
    protected $fillable = [
        'client_id',
        'project_reviewer_id',
        'meeting_datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'project_reviewer_id', 'id')->withTrashed();
    }
}
