<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Model;

class WpUser extends Model
{
    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'users';

    protected $primaryKey = 'ID';

    public function meta()
    {
        return $this->hasMany(WpUserMeta::class, 'user_id', 'ID');
    }
}
