<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrResourcesFactory;
use App\Models\UsersResourcesAndGuidelines;

class Resource extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'hr_resources';

    public function category()
    {
        return $this->belongsTo(Category::class, 'hr_resource_category_id');
    }
    public static function newFactory()
    {
        return new HrResourcesFactory();
    }

    public function getUsersResourcesAndGuidelines($resource_id, $employee_id)
    {
        return UsersResourcesAndGuidelines::where('employee_id', $employee_id)->where('resource_id', $resource_id)->first();
    }
}
