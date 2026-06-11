<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Model;

class WpOption extends Model
{
    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'options';

    protected $primaryKey = 'option_id';

    // WordPress serializes some option values (e.g. arrays). siteurl is a plain string
    // and works here as-is. If reused for other options, add unserialize() as needed.
    public static function get(string $key, $default = null)
    {
        $option = static::where('option_name', $key)->first();

        return $option ? $option->option_value : $default;
    }
}
