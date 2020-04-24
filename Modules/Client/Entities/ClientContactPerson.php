<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Model;

class ClientContactPerson extends Model
{
    /** This should be people but we doing this for consistency  */
    protected $table = 'client_contact_persons';
    protected $fillable = ['client_id', 'name', 'email', 'phone', 'type'];
}
