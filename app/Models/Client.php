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
    public static function getActiveClients()
    {
        return self::where('is_active', true)->get();
    }

    public function getCurrencyAttribute()
    {
        return config("constants.countries.$this->country.currency");
    }
}
