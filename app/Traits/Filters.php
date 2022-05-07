<?php

namespace App\Traits;

trait Filters
{
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeFilterByName($query, $name)
    {
        return $query->where('name', 'LIKE', "%$name%");
    }

    public function scopeApplyFilter($query, array $filters)
    {
        foreach (array_filter($filters) as $type => $value) {
            switch ($type) {
                case 'status':
                    $query->filterByStatus($value);
                    break;
                case 'name':
                    $query->filterByName($value);
            }
        }

        return $query;
    }
}
