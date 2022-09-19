<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Database\factories\MediaFactory;

class Media extends Model
{
    use HasFactory;
    protected $table = 'media';
    public $timestamps = false;
    protected $fillable = [
        'event_name',
        'img_url',
        'uploaded_by',
        'description'
    ];

    public static function newFactory()
    {
        return new MediaFactory();
    }
}
