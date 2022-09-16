<?php

namespace Modules\Revenue\Entities;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class RevenueProceed extends Model
{
    protected $table = 'revenue_proceeds';

    protected $guarded = [];

    protected $fillable = ['name', 'category', 'currency', 'amount', 'recieved_at', 'year', 'month', 'notes'];

    public function scopeApplyFilters($query, $filters)
    {
        if ($year = Arr::get($filters, 'year', 'false')) {
            $query = $query->where('year', $year);
        }

        if ($month = Arr::get($filters, 'month', 'false')) {
            $query = $query->where('month', $month);
        }

        return $query;
    }
}
