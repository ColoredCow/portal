<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'hr_resources';

    public function category()
    {
        return $this->belongsToMany(Category::class, 'hr_resources', 'hr_resource_category_id');
    }

    public function job()
    {
        return $this->belongsToMany(Job::class, 'hr_resources', 'job_id');
    }
}
