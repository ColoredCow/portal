<?php

namespace App\Models;

use App\Models\Configuration;
use App\Models\CreatesTenant;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use CreatesTenant;

    protected $connection = 'master';
    protected $guarded = [];

    public static function generateSlug($name)
    {
        return substr(camel_case($name), 0, 8);
    }

    public function configurations()
    {
        return $this->hasMany(Configuration::class);
    }
}
