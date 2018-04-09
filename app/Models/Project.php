<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'client_id', 'client_project_id', 'started_on', 'invoice_email', 'status', 'type', 'currency_cost', 'cost'];

    /**
     * Get the client that owns the project.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get details to list projects
     *
     * @return self
     */
    public static function getList()
    {
    	return self::with([ 'client' => function($query) {
	            $query->select('id', 'name');
	        }])
            ->orderBy('id', 'desc')
            ->get();
    }
}
