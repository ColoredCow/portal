<?php
namespace Modules\Client\Entities\Traits;

trait HasHierarchy
{
    /**
     * Scopes.
     */
    public function scopeOnTopLevel($query)
    {
        return $query->whereNull(['channel_partner_id', 'parent_organisation_id']);
    }

    /**
     * End scopes.
     */
    public function channelPartner()
    {
        return $this->belongsTo(self::class);
    }

    public function parentOrganisation()
    {
        return $this->belongsTo(self::class);
    }

    public function linkedAsPartner()
    {
        return $this->hasMany(self::class, 'channel_partner_id');
    }

    public function linkedAsDepartment()
    {
        return $this->hasMany(self::class, 'parent_organisation_id');
    }

    public function isTopLevel()
    {
        return ! ($this->channel_partner_id || $this->parent_organisation_id);
    }
}
