<?php

namespace Modules\Prospect\Entities;

use Illuminate\Database\Eloquent\Model;

class ProspectContactPerson extends Model
{
    /** This should be people but we doing this for consistency  */
    protected $table = 'prospect_contact_persons';
    protected $fillable = ['prospect_id', 'name', 'email', 'phone', 'brief_info'];
}
