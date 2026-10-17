<?php

namespace App\Models\WordPress;

use Illuminate\Database\Eloquent\Model;

// Composite primary key (object_id + term_taxonomy_id), no auto-increment id column.
// Safe for insert and query-builder updates, but save()/delete() on a fetched instance
// will misbehave because Eloquent looks for an id column.
class WpTermRelationship extends Model
{
    public $incrementing = false;

    public $timestamps = false;
    protected $connection = 'wordpress';

    protected $table = 'term_relationships';
}
