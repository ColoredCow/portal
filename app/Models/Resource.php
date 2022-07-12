<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Job;
use App\Models\Category;


class Resource extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'hr_resources';

    public function category()
    {
        return $this->belongsTo(Category::class, 'hr_resource_category_id');
    }
}
