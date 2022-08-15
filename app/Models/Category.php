<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrResourcesCategoriesFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'hr_resources_categories';
    public static function newFactory()
    {
        return new HrResourcesCategoriesFactory();
    }
}
