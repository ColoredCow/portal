<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $table = 'media';
    protected $fillable = [
        'event_name',
        'file_url',
        'uploaded_by',
        'description'
    ];
}
