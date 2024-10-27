<?php
namespace Modules\Prospect\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class ProspectComment extends Model
{
    protected $fillable = [];

    protected $table = 'prospect_comments';

    public function prospect()
    {
        return $this->belongsTo(Prospect::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
