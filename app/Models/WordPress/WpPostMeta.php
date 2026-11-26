<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Model;

class WpPostMeta extends Model
{
    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'postmeta';

    protected $primaryKey = 'meta_id';

    protected $fillable = ['post_id', 'meta_key', 'meta_value'];
}
