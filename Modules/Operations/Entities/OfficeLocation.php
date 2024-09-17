<?php

namespace Modules\Operations\Entities;

use App\Models\KnowledgeCafe\Library\BookLocation;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class OfficeLocation extends Model
{
    protected $guarded = [];

    public function centreHead()
    {
        return $this->belongsTo(User::class, 'centre_head_id');
    }

    public function locationOfBook()
    {
        return $this->hasMany(BookLocation::class, 'office_loaction_id');
    }
}
