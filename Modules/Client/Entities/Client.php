<?php

namespace Modules\Client\Entities;

use App\Traits\Filters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Database\Factories\ClientFactory;
use Modules\Client\Entities\Traits\HasHierarchy;
use Modules\Client\Entities\Scopes\ClientGlobalScope;

class Client extends Model
{
    use HasHierarchy, HasFactory, Filters;

    protected $fillable = ['name', 'key_account_manager_id', 'status', 'is_channel_partner', 'has_departments', 'channel_partner_id', 'parent_organisation_id', 'primary_project_id', 'client_id'];

    protected $appends = ['type', 'currency'];

    protected static function booted()
    {
        static::addGlobalScope(new ClientGlobalScope);
    }

    protected static function newFactory()
    {
        return new ClientFactory();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function keyAccountManager()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function projectLevelBillingProjects()
    {
        return $this->hasMany(Project::class)->select('projects.*')->where('projects.status', '!=', 'inactive')
            ->leftJoin('project_meta', function ($join) {
                $join->on('project_meta.project_id', '=', 'projects.id');
                $join->where('project_meta.key', '=', config('project.meta_keys.billing_level.value.project.key'));
            });
    }

    public function clientLevelBillingProjects()
    {
        return $this->hasMany(Project::class)->select('projects.*')->where('projects.status', '!=', 'inactive')
            ->leftJoin('project_meta', function ($join) {
                $join->on('project_meta.project_id', '=', 'projects.id');
                $join->where('project_meta.key', '=', config('project.meta_keys.billing_level.value.client.key'));
            });
    }

    public function getReferenceIdAttribute()
    {
        return sprintf('%03s', $this->id);
    }

    public function contactPersons()
    {
        return $this->hasMany(ClientContactPerson::class);
    }

    public function getBillingContactAttribute()
    {
        return $this->contactPersons()->where('type', 'billing-contact')->first();
    }

    public function primaryProject()
    {
        return $this->hasOne(Project::class, 'id', 'primary_project_id');
    }

    public function addresses()
    {
        return $this->hasMany(ClientAddress::class);
    }

    public function billingDetails()
    {
        return $this->hasOne(ClientBillingDetail::class)->withDefault();
    }

    public function getTypeAttribute()
    {
        $address = $this->addresses->first();
        if (! $address) {
            return;
        }

        return  $address->country_id == '1' ? 'indian' : 'international';
    }

    public function getCountryAttribute()
    {
        return optional($this->addresses->first())->country;
    }

    public function getCurrencyAttribute()
    {
        return $this->type == 'indian' ? 'INR' : 'USD';
    }

    public function getBillableAmountForTerm(int $month, int $year, $projects)
    {
        $amount = $projects->sum(function ($project) use ($month, $year) {
            return round($project->getBillableHoursForTerm($month, $year) * $this->billingDetails->service_rates, 2);
        });

        return $amount;
    }

    public function getTaxAmountForTerm(int $month, int $year, $projects)
    {
        // Todo: Implement tax calculation correctly as per the GST rules
        return round($this->getBillableAmountForTerm($month, $year, $projects) * ($this->country->initials == 'IN' ? config('invoice.tax-details.igst') : 0), 2);
    }

    public function getTotalPayableAmountForTerm(int $month, int $year, $projects)
    {
        return $this->getBillableAmountForTerm($month, $year, $projects) + $this->getTaxAmountForTerm($month, $year, $projects);
    }

    public function getAmountPaidForTerm(int $month, int $year, $projects)
    {
        // This needs to be updated based on the requirements.
        return 0.00;
    }
}
