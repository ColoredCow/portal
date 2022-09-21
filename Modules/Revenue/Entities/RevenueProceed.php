<?php

namespace Modules\Revenue\Entities;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class RevenueProceed extends Model
{
    protected $table = 'revenue_proceeds';

    protected $guarded = [];

    protected $appends = ['display_received_at'];

    protected $casts = [
        'received_at' => 'date',
    ];

    protected $fillable = ['name', 'category', 'currency', 'amount', 'received_at', 'year', 'month', 'notes'];

    public function scopeApplyFilters($query, $filters)
    {
        if ($year = Arr::get($filters, 'year', false)) {
            $query = $query->where(function ($q) use ($year) {
                $q->where('year', $year)->where('month', '>', 3);
            })->orWhere(function ($q) use ($year) {
                $q->where('year', $year + 1)->where('month', '<', 4);
            });
        }

        return $query;
    }

    public function getDisplayReceivedAtAttribute()
    {
        return $this->received_at->format('Y-m-d');
    }
}
