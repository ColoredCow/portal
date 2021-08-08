<?php

namespace Modules\Audit\Entities;

use App\Traits\ModuleBaseEntities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audit extends Model
{
    use SoftDeletes, ModuleBaseEntities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new AuditUserRoleScope);
    }
}
