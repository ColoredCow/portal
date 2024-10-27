<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class Comment extends Model
{
    protected $casts = [
        'created_at' => 'datetime: D d M @ h:i',
        'updated_at' => 'datetime: D d M @ h:i',
    ];

    protected $with = ['user'];
    protected $guarded = [];

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
