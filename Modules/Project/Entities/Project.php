<?php

namespace Modules\Project\Entities;

use App\Traits\Filters;
use App\Traits\HasTags;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Modules\Client\Entities\Client;
use Modules\EffortTracking\Entities\Task;
use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Services\InvoiceService;
use Modules\Project\Database\Factories\ProjectFactory;
use Modules\User\Entities\User;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use HasFactory;
    use HasTags;
    use Filters;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'projects';

    protected $guarded = [];

    protected $dates = ['start_date', 'end_date'];

    protected $appends = ['velocity', 'current_hours_for_month', 'velocity_color_class'];

    public function scopeIsAMC($query, $isAmc)
    {
        $query->where('is_amc', $isAmc);
    }

    public function scopeLinkedToTeamMember($query, $userId)
    {
        return $query->whereHas('getTeamMembers', function ($query) use ($userId) {
            $query->where('team_member_id', $userId);
        });
    }

    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'project_team_members', 'project_id', 'team_member_id')
            ->withPivot('designation', 'ended_on', 'id', 'daily_expected_effort', 'billing_engagement', 'started_on', 'ended_on')->withTimestamps()->whereNull('project_team_members.ended_on');
    }

    public function repositories()
    {
        return $this->hasMany(ProjectRepository::class);
    }

    public function invoiceTerms()
    {
        return $this->hasMany(ProjectInvoiceTerm::class);
    }

    public function resourceRequirement()
    {
        return $this->hasMany(ProjectResourceRequirement::class);
    }

    public function getResourceRequirementByDesignation($designationName)
    {
        return $this->resourceRequirement()->where('designation', $designationName)->first();
    }

    public function getDeployedCountForDesignation($designation)
    {
        return $this->getTeamMembers()->where('designation', '=', $designation)->count();
    }

    public function getToBeDeployedCountForDesignation($designation)
    {
        $resourceRequirementCount = optional($this->getResourceRequirementByDesignation($designation))->total_requirement ?? 0;
        $deployedCount = $this->getDeployedCountForDesignation($designation);
        $toBeDeployedCount = $resourceRequirementCount - $deployedCount;

        return $toBeDeployedCount > 0 ? $toBeDeployedCount : ($toBeDeployedCount < 0 ? $toBeDeployedCount : '0');
    }

    public function getTotalToBeDeployedCount()
    {
        $designations = array_keys(config('project.designation'));
        $totalToBeDeployedCount = 0;
        foreach ($designations as $designationName) {
            $totalToBeDeployedCount += $this->getToBeDeployedCountForDesignation($designationName);
        }

        return $totalToBeDeployedCount;
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeStatus($query, $status)
    {
        return $query->whereStatus($status);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getTeamMembers()
    {
        return $this->hasMany(ProjectTeamMember::class)->whereNULL('ended_on');
    }

    public function getKeyAccountManagerAttribute()
    {
        return $this->client->keyAccountManager;
    }

    public function getTeamMembersGroupedByEngagement()
    {
        return $this->getTeamMembers()->select('billing_engagement', DB::raw('count(*) as resource_count'))->groupBy('billing_engagement')->get();
    }

    public function getInactiveTeamMembers()
    {
        return $this->hasMany(ProjectTeamMember::class)->whereNotNull('ended_on')->orderBy('ended_on', 'DESC');
    }

    public function getAllTeamMembers()
    {
        return $this->hasMany(ProjectTeamMember::class);
    }

    public function projectContracts()
    {
        return $this->hasMany(ProjectContract::class);
    }

    public function getExpectedHoursInMonthAttribute($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? $this->client->month_start_date;
        $endDate = $endDate ?? $this->client->month_end_date;
        $daysInMonth = count($this->getWorkingDaysList($startDate, $endDate));
        $teamMembers = $this->getTeamMembers()->get();
        $currentExpectedEffort = 0;

        foreach ($teamMembers as $teamMember) {
            $currentExpectedEffort += $teamMember->daily_expected_effort * $daysInMonth;
        }

        return round($currentExpectedEffort, 2);
    }

    public function getHoursBookedForMonth($monthToSubtract = 1, $startDate = null, $endDate = null)
    {
        $startDate = $startDate ?: $this->client->getMonthStartDateAttribute($monthToSubtract);
        $endDate = $endDate ?: $this->client->getMonthEndDateAttribute($monthToSubtract);

        return $this->getAllTeamMembers->sum(function ($teamMember) use ($startDate, $endDate) {
            if (! $teamMember->projectTeamMemberEffort) {
                return 0;
            }

            return $teamMember->projectTeamMemberEffort()
                ->where('added_on', '>=', $startDate)
                ->where('added_on', '<=', $endDate)
                ->sum('actual_effort');
        });
    }

    public function getVelocityForMonthAttribute($monthToSubtract, $startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? $this->client->month_start_date;
        $endDate = $endDate ?? $this->client->month_end_date;

        return $this->getExpectedHoursInMonthAttribute($startDate, $endDate) ? round($this->getHoursBookedForMonth($monthToSubtract, $startDate, $endDate) / $this->getExpectedHoursInMonthAttribute($startDate, $endDate), 2) : 0;
    }

    public function getCurrentHoursForMonthAttribute()
    {
        $teamMembers = $this->getTeamMembers()->get();
        $actualEffort = 0;

        foreach ($teamMembers as $teamMember) {
            $actualEffort += $teamMember->projectTeamMemberEffort->whereBetween('added_on', [$this->client->month_start_date->subday(), $this->client->month_end_date])->sum('actual_effort');
        }

        return $actualEffort;
    }

    public function getTotalEffort()
    {
        $teamMembers = $this->getTeamMembers()->get();
        $totalEffort = [];

        foreach ($teamMembers as $teamMember) {
            $totalEffort[] = $teamMember->projectTeamMemberEffort->whereBetween('added_on', [$this->client->month_start_date->subday(), $this->client->month_end_date])->sum('total_effort_in_effortsheet');
        }

        return $totalEffort;
    }

    public function getDailyTotalEffort()
    {
        $teamMEmbers = $this->getTeamMembers()->get();
        $totalEffortPerDay = 0;

        foreach ($teamMEmbers as $teamMember) {
            $totalEffortPerDay += $teamMember->daily_expected_effort;
        }

        return $totalEffortPerDay;
    }

    public function getactualEffortOfTeamMember($id)
    {
        $teamMembers = new ProjectTeamMemberEffort();
        $currentMonth = date('m');

        $actualEffort = $teamMembers->where('project_team_member_id', $id)
                                    ->whereMonth('added_on', $currentMonth)
                                    ->sum('employee_actual_working_effort');

        return $actualEffort;
    }
    public function getbillableEffortOfTeamMember($id)
    {
        $teamMembers = new ProjectTeamMemberEffort();
        $currentMonth = date('m');

        $billableEffort = $teamMembers->where('project_team_member_id', $id)
                                    ->whereMonth('added_on', $currentMonth)
                                    ->sum('actual_effort');

        return $billableEffort;
    }

    public function getVelocityAttribute()
    {
        return $this->current_expected_hours ? round($this->current_hours_for_month / $this->current_expected_hours, 2) : 0;
    }

    public function getWorkingDaysList($startDate, $endDate)
    {
        $period = CarbonPeriod::create($startDate, $endDate);

        $dates = [];
        $weekend = ['Saturday', 'Sunday'];
        foreach ($period as $date) {
            if (! in_array($date->format('l'), $weekend)) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        return $dates;
    }

    public function getIsReadyToRenewAttribute()
    {
        $diff = optional($this->end_date)->diffInDays(today());

        if ($diff === null) {
            return true;
        }

        if ($this->end_date <= today()) {
            return true;
        }

        if ($diff <= 30) {
            return false;
        }

        return false;
    }

    public function getCurrentExpectedHoursAttribute()
    {
        $currentDate = today(config('constants.timezone.indian'));

        if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = $currentDate->subDay();
        }

        return $this->getExpectedHours($currentDate);
    }

    public function getExpectedHoursTillTodayAttribute()
    {
        return $this->getExpectedHours(today(config('constants.timezone.indian')));
    }

    public function getExpectedHours($currentDate)
    {
        $teamMembers = $this->getTeamMembers()->get();
        $daysTillToday = count($this->getWorkingDaysList($this->client->month_start_date, $currentDate));
        $currentExpectedEffort = 0;

        foreach ($teamMembers as $teamMember) {
            $currentExpectedEffort += $teamMember->daily_expected_effort * $daysTillToday;
        }

        return round($currentExpectedEffort, 2);
    }

    public function getExpectedMonthlyHoursAttribute()
    {
        $teamMembers = $this->getTeamMembers()->get();
        $workingDaysCount = count($this->getWorkingDaysList($this->client->month_start_date, $this->client->month_end_date));
        $expectedMonthlyHours = 0;

        foreach ($teamMembers as $teamMember) {
            $expectedMonthlyHours += $teamMember->daily_expected_effort * $workingDaysCount;
        }

        return round($expectedMonthlyHours, 2);
    }

    public function getBillableAmountForTerm(int $monthToSubtract = 1, $periodStartDate = null, $periodEndDate = null)
    {
        return round($this->getBillableHoursForMonth($monthToSubtract, $periodStartDate, $periodEndDate) * $this->client->billingDetails->service_rates, 2);
    }

    public function getTaxAmountForTerm($monthToSubtract = 1, $periodStartDate = null, $periodEndDate = null)
    {
        // Todo: Implement tax calculation correctly as per the GST rules
        return round($this->getBillableAmountForTerm($monthToSubtract, $periodStartDate, $periodEndDate) * ($this->client->country->initials == 'IN' ? config('invoice.tax-details.igst') : 0), 2);
    }

    public function getTotalPayableAmountForTerm(int $monthToSubtract = 1, $periodStartDate = null, $periodEndDate = null)
    {
        return $this->getBillableAmountForTerm($monthToSubtract, $periodStartDate, $periodEndDate) + $this->getTaxAmountForTerm($monthToSubtract, $periodStartDate, $periodEndDate) + optional($this->client->billingDetails)->bank_charges;
    }

    public function getBillableHoursForMonth($monthToSubtract = 1, $periodStartDate = null, $periodEndDate = null)
    {
        $startDate = $periodStartDate ?: $this->client->getMonthStartDateAttribute($monthToSubtract);
        $endDate = $periodEndDate ?: $this->client->getMonthEndDateAttribute($monthToSubtract);

        return $this->getAllTeamMembers->sum(function ($teamMember) use ($startDate, $endDate) {
            if (! $teamMember->projectTeamMemberEffort) {
                return 0;
            }

            return $teamMember->projectTeamMemberEffort()
                ->where('added_on', '>=', $startDate)
                ->where('added_on', '<=', $endDate)
                ->sum('actual_effort');
        });
    }

    public function getResourceBillableAmount()
    {
        $service_rate = optional($this->billingDetail)->service_rates;
        if (! $service_rate) {
            $service_rate = $this->client->billingDetails->service_rates;
        }
        $totalAmount = 0;
        $numberOfMonths = 1;

        switch ($this->client->billingDetails->billing_frequency) {
            case 3:
                $numberOfMonths = 3;
                break;
            default:
                $numberOfMonths = 1;
        }

        foreach ($this->getTeamMembersGroupedByEngagement() as $groupedResources) {
            $totalAmount += $groupedResources->billing_engagement / 100 * $groupedResources->resource_count * $service_rate * $numberOfMonths;
        }

        return round($totalAmount, 2);
    }

    public function meta()
    {
        return $this->hasMany(ProjectMeta::class);
    }

    public function getMetaValue($metaKey)
    {
        $meta = $this->meta()->where('key', $metaKey)->first();
        if ($meta) {
            return $meta->value;
        }
    }

    public function getBillingLevelAttribute()
    {
        return optional($this->meta()->where('key', 'billing_level')->first())->value;
    }

    public function getLastUpdatedAtAttribute()
    {
        return optional($this->meta()->where('key', 'last_updated_at')->first())->value;
    }

    public function getNextInvoiceNumberAttribute()
    {
        $invoiceService = new InvoiceService();

        return $invoiceService->getInvoiceNumberPreview($this->client, $this, today(), config('project.meta_keys.billing_level.value.project.key'));
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function scopeInvoiceReadyToSend($query)
    {
        $query->whereDoesntHave('invoices', function ($query) {
            return $query->whereMonth('sent_on', now(config('constants.timezone.indian')))->whereYear('sent_on', now(config('constants.timezone.indian')));
        })->whereHas('client.billingDetails', function ($query) {
            return $query->where('billing_date', '<=', today()->format('d'));
        });
    }

    public function scopeBillable($query, $billable = true)
    {
        return $query->where('type', $billable ? '<>' : '=', 'non-billable');
    }

    public function hasCustomInvoiceTemplate()
    {
        $template = config('invoice.templates.invoice.projects.' . $this->name);

        if ($template) {
            return true;
        }

        return false;
    }

    public function billingDetail()
    {
        return $this->hasOne(ProjectBillingDetail::class);
    }

    public function getVelocityColorClassAttribute()
    {
        $today = today(config('constants.timezone.indian'));
        $billingDate = $this->client->billingDetails->billing_date;
        $todayDate = (int) $today->format('j');

        return $billingDate == $todayDate ? 'text-dark' : ($this->velocity >= 1 ? 'text-success' : 'text-danger');
    }

    protected static function newFactory()
    {
        return new ProjectFactory();
    }
}
