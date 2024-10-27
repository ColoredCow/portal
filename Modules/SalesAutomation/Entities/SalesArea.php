<?php
namespace Modules\SalesAutomation\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SalesAutomation\Traits\HasFilters;

class SalesArea extends Model
{
    use HasFilters;

    protected $guarded = [];
}
