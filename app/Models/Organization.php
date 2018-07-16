<?php

namespace App\Models;

use App\Models\Configuration;
use App\Models\CreatesTenant;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use CreatesTenant, IsMasterModel;

    protected $guarded = [];


    public static function generateSlug($name)
    {
        return substr(camel_case($name), 0, 8);
    }

    public function configurations()
    {
        return $this->hasMany(Configuration::class);
    }

    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }

    /**
     * Returns the absolute path of the private key file for GSuite domain wide delegation access.
     *
     * @return string
     */
    public function getPrivateKeyFilePath()
    {
        $filePath = optional($this->configurations->where('key', 'service_account_private_key_file')->first())->value;
        return storage_path("/app/$filePath");
    }
}
