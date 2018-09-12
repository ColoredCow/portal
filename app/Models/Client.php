<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    protected $appends = ['currency'];

    /**
     * Get the projects for the client.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getCurrencyAttribute()
    {
        return config("constants.countries.$this->country.currency");
    }

    public static function getInvoicableClients()
    {
        return self::active()
            ->whereHas('projects', function ($query) {
                $query->whereHas('stages', function ($query) {
                    $query->whereHas('billings', function ($query) {
                        $query->whereNull('invoice_id');
                    });
                });
            })
            ->with([
                'projects' => function ($query) {
                    $query->whereHas('stages', function ($query) {
                        $query->whereHas('billings', function ($query) {
                            $query->doesntHave('invoice');
                        });
                    });
                },
                'projects.stages' => function ($query) {
                    $query->whereHas('billings', function ($query) {
                        $query->doesntHave('invoice');
                    });
                },
                'projects.stages.billings' => function ($query) {
                    $query->doesntHave('invoice');
                },
            ])
            ->get();
    }
}
