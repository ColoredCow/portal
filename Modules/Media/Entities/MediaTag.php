<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaTag extends Model
{
    use HasFactory;
    protected $table = 'media_tag';
    protected $fillable = [
        'id',
        'media_id',
        'media_tag_name',
        'media_type',
    ];
}