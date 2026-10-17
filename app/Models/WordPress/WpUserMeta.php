<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Model;

class WpUserMeta extends Model
{
    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'usermeta';

    protected $primaryKey = 'umeta_id';
}
