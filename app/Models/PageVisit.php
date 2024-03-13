<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PageVisitable;

class PageVisit extends Model
{
    use HasFactory, PageVisitable;

    protected $fillable = ['user_id', 'page_path', 'visit_count'];
}
