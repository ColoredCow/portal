<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model
{
    use HasFactory;
    protected $table = 'photo_gallery';
    protected $fillable = [
        'event_name',
        'img_url',
        'uploaded_by',
        'description'
    ];
}
