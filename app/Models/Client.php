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

    /**
     * Retrive id and name of clients with active flag true
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getInvoicableClients()
    {
        return self::where('is_active', true)
        // ->whereHas(
        //     'projects.stages.billings', function ($query) {
        //         $query->whereNull('invoice_id');
        //     }
        // )
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
                            $query->whereNull('invoice_id');
                        });
                    });
                },
                // 'projects.stages' => function ($query) {
                //     $query->whereHas('billings', function ($query) {
                //         $query->whereNull('invoice_id');
                //     });
                // },
                // 'projects.stages.billings' => function ($query) {
                //     $query->whereNull('invoice_id');
                // },
            ])->get();
    }

    public function getCurrencyAttribute()
    {
        return config("constants.countries.$this->country.currency");
    }
}
