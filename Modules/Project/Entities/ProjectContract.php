<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Project\Database\Factories\ProjectContractFactory;

class ProjectContract extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'contract_file_path', 'uuid'];

    protected static function booted()
    {
        static::creating(function (ProjectContract $contract) {
            if (empty($contract->uuid)) {
                $contract->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function newFactory()
    {
        return ProjectContractFactory::new();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
