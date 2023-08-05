<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'user_meta';
    protected $fillable = ['user_id', 'meta_key', 'meta_value'];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeKey($query, $metaKey)
    {
        return $query->where('meta_key', $metaKey);
    }
}
