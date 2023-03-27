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
use Modules\Invoice\Entities\LedgerAccount;
use Modules\Invoice\Services\InvoiceService;
use Modules\Project\Database\Factories\ProjectFactory;
use Modules\User\Entities\User;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class Project extends Model implements Auditable
{
    use HasFactory, HasTags, Filters, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'projects';

    protected $guarded = [];

    protected $dates = ['start_date', 'end_date'];

    protected static function newFactory()
    {
        return new ProjectFactory();
    }

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

        return ($toBeDeployedCount > 0) ? $toBeDeployedCount : (($toBeDeployedCount < 0) ? $toBeDeployedCount : '0');
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

        return $this->getExpectedHoursInMonthAttribute($startDate, $endDate) ? round($this->getHoursBookedForMonth($monthToSubtract, $startDate, $endDate) / ($this->getExpectedHoursInMonthAttribute($startDate, $endDate)), 2) : 0;
    }

    public function getCurrentHoursForMonthAttribute()
    {
        $teamMembers = $this->getTeamMembers()->get();
        $totalEffort = 0;

        foreach ($teamMembers as $teamMember) {
            $totalEffort += $teamMember->projectTeamMemberEffort->whereBetween('added_on', [$this->client->month_start_date->subday(), $this->client->month_end_date])->sum('actual_effort');
        }

        return $totalEffort;
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
        } elseif ($this->end_date <= today()) {
            return true;
        } elseif ($diff <= 30) {
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

    public function getBillableAmountForTerm($periodStartDate = null, $periodEndDate = null)
    {
        return round($this->getBillableHoursForTerm($periodStartDate, $periodEndDate) * $this->service_rates, 2);
    }

    public function getTaxAmountForTerm($periodStartDate = null, $periodEndDate = null)
    {
        // Todo: Implement tax calculation correctly as per the GST rules
        return round($this->getBillableAmountForTerm($periodStartDate, $periodEndDate) * ($this->client->country->initials == 'IN' ? config('invoice.tax-details.igst') : 0), 2);
    }

    public function getTotalPayableAmountForTerm(int $monthToSubtract = 1, $periodStartDate = null, $periodEndDate = null)
    {
        return $this->getBillableAmountForTerm($periodStartDate, $periodEndDate) + $this->getTaxAmountForTerm($periodStartDate, $periodEndDate) + optional($this->client->billingDetails)->bank_charges;
    }

    public function getBillableHoursForTerm($termStartDate, $termEndDate)
    {
        return $this->getAllTeamMembers->sum(function ($teamMember) use ($termStartDate, $termEndDate) {
            if (! $teamMember->projectTeamMemberEffort) {
                return 0;
            }

            return $teamMember->projectTeamMemberEffort()
                ->where('added_on', '>=', $termStartDate)
                ->where('added_on', '<=', $termEndDate)
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

        //# Todo: Calculate billing_frequency

        switch ($this->client->billingDetails->billing_frequency) {
            case 3:
                $numberOfMonths = 3;
                break;
            default:
                $numberOfMonths = 1;
        }

        foreach ($this->getTeamMembersGroupedByEngagement() as $groupedResources) {
            $totalAmount += ($groupedResources->billing_engagement / 100) * $groupedResources->resource_count * $service_rate * $numberOfMonths;
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
        } else {
            return;
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

    public function ledgerAccounts()
    {
        return $this->hasMany(LedgerAccount::class);
    }

    public function ledgerAccountsOnlyCredit()
    {
        return $this->ledgerAccounts()->whereNotNull('credit');
    }

    public function ledgerAccountsOnlyDebit()
    {
        return $this->ledgerAccounts()->whereNotNull('debit');
    }

    public function getTotalLedgerAmount($quarter = null)
    {
        $amount = 0;
        $amount += (optional($this->ledgerAccountsOnlyCredit()->quarter($quarter))->get()->sum('credit') - optional($this->ledgerAccountsOnlyDebit()->quarter($quarter))->get()->sum('debit'));

        return $amount;
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

    public function getBillingFrequencyAttribute() // Billing frequency is based on Client
    {
        $billingFrequency = $this->client->billingDetails->billing_frequency;

        return $billingFrequency;
    }

    public function getstartDate()
    {
        $previousInvoice = invoice::where('project_id', $this->client_project_id)->orderby('sent_on', 'desc')->first();

        if ($previousInvoice) {
            $previousBillingDate = $previousInvoice->sent_on;
        } else {
            $billingDate = DB::table('client_billing_details')->select('billing_date')->where('client_id', $this->client->id)->value('billing_date');
            $previousBillingDate = $this->created_at->format('Y-m-d');

            return Carbon::createFromFormat('Y-m-d', $previousBillingDate)->day($billingDate)->toDateString();
        }

        return $previousBillingDate->format('Y-m-d');
    }

    public function getNextBillingDateAttribute() // In this function nextbilling date comes from client level.
    {
        $billingFrequencyId = optional($this->projectDetail)->billing_frequency;

        if ($billingFrequencyId == null) {       // next billing date will calculate based on project
            $billingFrequencyId = $this->client->billingDetails->billing_frequency;
        }

        switch ($billingFrequencyId) {
            case 2: // monthly
                $monthsToAdd = 1;
                break;
            case 3: // quarterly
                $monthsToAdd = 3;
                break;
            case 4: // yearly
                $monthsToAdd = 12;
                break;
            default:
                $monthsToAdd = 1;
        }

        $previousInvoice = $this->invoices()->orderby('sent_on', 'desc')->first();
        if ($previousInvoice) {
            $previousBillingDate = Carbon::parse($previousInvoice->term_end_date)->addDay();
        } else {
            $previousBillingDate = $this->last_marked_as_active_date ?? $this->created_at;
        }

        $previousBillingDate = Carbon::parse($previousBillingDate);
        $nextBillingDate = $previousBillingDate->addMonthsNoOverflow($monthsToAdd)->format('Y-m-d');
        $nextBillingDate = Carbon::parse($nextBillingDate);

        return $nextBillingDate->subDays(2)->format('Y-m-d');
    }

    public function getClientName($client_id) // return name from client table based of id.
    {
        if ($client_id) {
            $clientName = client::where('id', $client_id)->value('name');

            return $clientName;
        }

        return '';
    }

    public function getServiceRateTermAttribute()
    {
        $billingDetail = $this->billingDetail;

        if ($billingDetail) {
            return $billingDetail->service_rate_term;
        } else {
            return  optional($this->client->billingDetails)->service_rate_term;
        }
    }

    public function getBillingLevel()
    {
        $billingLevel = ProjectMeta::where('project_id', $this->id)->value('value');

        return $billingLevel;
    }

    public function getTermStartAndEndDateForInvoice() // Importent function: based on client frequency
    {
        $clientBillingDate = $this->client->billingDetails->billing_date;
        $startDate = $this->getTermStartDate($clientBillingDate);
        $startDate = carbon::parse($startDate);
        $endDate = $this->getTermEndDate($startDate, $clientBillingDate);

        return [
            'startDate'=>$startDate,
            'endDate'=>$endDate
        ];
    }

    public function getTermStartDate($clientBillingDate)
    {
        $previousInvoice = $this->invoices()->orderby('sent_on', 'desc')->first();
        $lastProjectActiveDate = $this->last_marked_as_active_date ?? $this->created_at;
        if (optional($previousInvoice)->term_end_date) {
            $lastInvoiceDate = $previousInvoice->term_end_date->addDay()->day($clientBillingDate);
            if ($lastInvoiceDate->greaterThanOrEqualTo($lastProjectActiveDate)) {
                return $lastInvoiceDate;
            }
        }

        return $lastProjectActiveDate;
    }

    public function getTermEndDate($startDate, $clientBillingDate)
    {
        $billingFrequencyId = $this->client->billingDetails->billing_frequency;
        $startdate = $startDate;
        $startdate = Carbon::parse($startdate);

        if ($billingFrequencyId == config('client.billing-frequency.quarterly.id')) { // clientFrequency = 3
            $endDate = $startdate->addMonthsNoOverflow(3)->startOfMonth()->day($clientBillingDate - 1);
        } elseif ($billingFrequencyId == config('client.billing-frequency.monthly.id')) { // clientFrequency = 1
            $endDate = $startdate->addMonthNoOverflow()->startOfMonth()->day($clientBillingDate - 1);
        } elseif ($billingFrequencyId == config('client.billing-frequency.yearly.id')) { // clientFrequency = 4
            $endDate = $startdate->addYearNoOverflow()->startOfMonth()->day($clientBillingDate - 1);
        } else {
            $endDate = $startdate->addMonthNoOverflow()->startOfMonth()->day($clientBillingDate - 1);
        }

        return $endDate;
    }

    public function amountWithoutTaxForTerm($termStartDate, $termEndDate)
    {
        $serviceRateTerm = $this->service_rate_term;

        switch ($serviceRateTerm) {
            case 'per_hour':
                $totalAmountInMonth = $this->getAmountForTermPerHour($termStartDate, $termEndDate);

                return  $totalAmountInMonth;
            case 'per_month':
                $totalAmountInMonth = $this->getAmountForTermPerMonth();

                return  $totalAmountInMonth;
            case 'per_quarter':
                $totalAmountInQuater = $this->getAmountForTermPerQuarterly();

                return  $totalAmountInQuater;
            case 'per_year':
                $totalAmountInYear = $this->getServiceRateAttribute();

                return $totalAmountInYear;
            case 'per_resource':

                return $this->getResourceBillableAmount();
            default:

                return;
        }
    }

    public function getServiceRateAttribute()
    {
        $details = DB::table('project_billing_details')->where('project_id', $this->id)->first();
        $clientServiceRate = $this->client->billingDetails->service_rates;

        if (! empty($details) && $details->service_rates) {
            return $details->service_rates;
        }

        if (! empty($clientServiceRate)) {
            return $clientServiceRate;
        }

        return 0;
    }

    public function getAmountForTermPerHour($termStartDate, $termEndDate)
    {
        $termStartDate = Carbon::parse($termStartDate);
        $termEndDate = Carbon::parse($termEndDate);
        // amount will be 0 if Billablehours = 0.

        $amount = ($this->getServiceRateAttribute() * $this->getBillableHoursForTerm($termStartDate, $termEndDate));

        return $amount;
    }

    public function getAmountForTermPerMonth()
    {
        $billing_frequency = $this->billingDetail->billing_frequency;

        $totalAmountInMonth = $this->getServiceRateAttribute();

        if ($billing_frequency == 1 || $billing_frequency == 2) { // monthly
            return  $totalAmountInMonth;
        }
        if ($billing_frequency == 3) { // Quarterly
            return  $totalAmountInMonth * 3;
        }
        if ($billing_frequency == 4) { // yearly
            return  $totalAmountInMonth * 12;
        }

        return $totalAmountInMonth;
    }

    public function getAmountForTermPerQuarterly()
    {
        $totalAmountInQuater = $this->getServiceRateAttribute();
        $billing_frequency = $this->billingDetail->billing_frequency;

        if ($billing_frequency == 3) { // Quarterly
            return  $totalAmountInQuater;
        }
        if ($billing_frequency == 4) { // yearly
            return  $totalAmountInQuater * 4;
        }

        return $totalAmountInQuater;
    }

    public function amountWithTaxForTerm($termStartDate, $termEndDate)
    {
        $termStartDate = Carbon::parse($termStartDate);
        $termEndDate = Carbon::parse($termEndDate);
        $amount = $this->amountWithoutTaxForTerm($termStartDate, $termEndDate);
        $bankCharge = optional($this->client->billingDetails)->bank_charges;
        $totalAmount = $amount + $bankCharge;
        $gstPercentage = config('invoice.invoice-details.igst');
        $gst = $totalAmount * floatval($gstPercentage) / 100;

        return round($totalAmount + $gst, 2);
    }

    public function gstAmountForTerm($termStartDate, $termEndDate)
    {
        $termStartDate = Carbon::parse($termStartDate);
        $termEndDate = Carbon::parse($termEndDate);
        $amount = $this->amountWithoutTaxForTerm($termStartDate, $termEndDate);
        $ledgerAmount = null;
        $bankCharge = optional($this->client->billingDetails)->bank_charges;
        $totalAmount = $amount + $ledgerAmount + $bankCharge;
        $gstPercentage = config('invoice.invoice-details.igst');
        $gst = $totalAmount * floatval($gstPercentage) / 100;

        return round($gst, 2);
    }

    public function getTermText($termStartDate, $termEndDate)
    {
        $termStartDate = Carbon::parse($termStartDate);
        $termEndDate = Carbon::parse($termEndDate);
        $billingStartMonth = $termStartDate->subMonthsNoOverflow(1)->format('M');
        $billingStartMonthYear = $termStartDate->format('Y');
        $billingEndMonth = $termEndDate->subMonthsNoOverflow(1)->format('M');
        $billingEndMonthYear = $termEndDate->format('Y');
        $termText = $billingStartMonth . ' ' . $billingStartMonthYear . ' - ' . $billingEndMonth . ' ' . $billingEndMonthYear;

        if ($billingStartMonth == $billingEndMonth) {
            $termText = $termStartDate->format('F');
        }

        return $termText;
    }
}
