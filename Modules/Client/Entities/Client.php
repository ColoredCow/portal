<?php

namespace Modules\Client\Entities;

use Modules\User\Entities\User;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'email', 'key_account_manager_id', 'status', 'country', 'state', 'phone', 'phone', 'address', 'pincode', 'is_channel_partner', 'has_departments', 'channel_partner_id', 'parent_organisation_id'];

    public function keyAccountManager()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getReferenceIdAttribute()
    {
        return sprintf('%03s', $this->id) ;
    }

    public function channelPartner()
    {
        return $this->belongsTo(self::class);
    }

    public function parentOrganisation()
    {
        return $this->belongsTo(self::class);
    }
}
