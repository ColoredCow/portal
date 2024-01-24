<?php

namespace Modules\SalesAutomation\Traits;

trait HasFilters
{
    public function scopeFilter($query, $columns, $value)
    {
        foreach ($columns as $column) {
            $query->where($this->getTable() . ".{$column}", 'like', "%{$value}%");
        }

        return $query;
    }

    public function scopeOrFilter($query, $columns, $value)
    {
        foreach ($columns as $column) {
            $query->orWhere($this->getTable() . ".{$column}", 'like', "%{$value}%");
        }

        return $query;
    }
}
