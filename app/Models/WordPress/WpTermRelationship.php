<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Model;

class WpTermRelationship extends Model
{
    public $incrementing = false;

    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'term_relationships';
}
