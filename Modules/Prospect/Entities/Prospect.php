<?php
namespace Modules\Prospect\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class Prospect extends Model
{
    protected $fillable = [];
    protected $table = 'prospects';

    public function pocUser()
    {
        return $this->belongsTo(User::class, 'poc_user_id');
    }

    public function comments()
    {
        return $this->hasMany(ProspectComment::class);
    }
}
