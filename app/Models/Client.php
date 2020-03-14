<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    protected $appends = ['currency', 'reference_number'];

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

    public function getReferenceNumberAttribute()
    {
        return config("constants.countries.$this->country.ref") 
            . $this->getOriginal('reference_number');
    }

    /**
     * Returns the clients with relations that can be invoiced.
     *
     * @param  array  $billings    Billings for which client should be added in the response.
     * @return self
     */
    public static function getInvoicableClients(array $billings = [])
    {
        return self::active()
            // ->whereHas('projects', function ($query) use ($billings) {
            //     $query->whereHas('stages', function ($query) use ($billings) {
            //         // $query->whereHas('billings', function ($query) use ($billings) {
            //         //     $query->doesntHave('invoice')->orWhereIn('id', $billings);
            //         // });
            //     });
            // })
            ->with([
                'projects' => function ($query) use ($billings) {
                    // $query->whereHas('stages', function ($query) use ($billings) {
                    //     $query->whereHas('billings', function ($query) use ($billings) {
                    //         $query->doesntHave('invoice')->orWhereIn('id', $billings);
                    //     });
                    // });
                },

                'projects.billingInfo' => function ($query) {},

                'projects.stages' => function ($query) use ($billings) {
                    $query->whereHas('billings', function ($query) use ($billings) {
                        $query->doesntHave('invoice')->orWhereIn('id', $billings);
                    });
                },
                'projects.stages.billings' => function ($query) use ($billings) {
                    $query->doesntHave('invoice')->orWhereIn('id', $billings);
                }
            ])
            ->get();
    }
}
