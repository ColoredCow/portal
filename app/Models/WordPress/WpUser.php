<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Model;

class WpUser extends Model
{
    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'users';

    protected $primaryKey = 'ID';

    protected $hidden = ['user_pass', 'user_activation_key', 'meta'];

    public function meta()
    {
        return $this->hasMany(WpUserMeta::class, 'user_id', 'ID');
    }
}
