<?php

namespace Modules\ProjectContract\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectContractMeta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project_contract_meta';

    protected $casts = [
        'attributes' => 'array',
    ];

    protected $guarded = [];
}
