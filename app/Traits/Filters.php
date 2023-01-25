<?php

namespace App\Traits;

use App\Traits\HasTags;

trait Filters
{
    use HasTags;

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
        foreach ($filters as $type => $value) {
            switch ($type) {
                case 'status':
                    $query->filterByStatus($value);
                    break;
                case 'name':
                    $query->filterByName($value);
                    break;
                case 'is_amc':
                    $query->isAMC($value);
                    break;
                case 'tags':
                    $query->filterByTags($value);
                    break;
            }
        }

        return $query;
    }
}
