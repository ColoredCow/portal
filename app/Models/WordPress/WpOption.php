<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Model;

class WpOption extends Model
{
    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'options';

    protected $primaryKey = 'option_id';

    public static function get(string $key, $default = null)
    {
        $option = static::where('option_name', $key)->first();

        return $option ? $option->option_value : $default;
    }
}
