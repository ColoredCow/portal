<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Model;

class WpTerm extends Model
{
    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'terms';

    protected $primaryKey = 'term_id';
}
