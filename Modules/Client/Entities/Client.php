<?php

namespace Modules\Client\Entities;

use App\Traits\Filters;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;
use Modules\Client\Database\Factories\ClientFactory;
use Modules\Client\Entities\Traits\HasHierarchy;
use Modules\Client\Entities\Scopes\ClientGlobalScope;
use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Entities\LedgerAccount;
use Modules\Invoice\Services\InvoiceService;

class Client extends Model
{
    use HasHierarchy, HasFactory, Filters;

    protected $fillable = ['name', 'key_account_manager_id', 'status', 'is_channel_partner', 'has_departments', 'channel_partner_id', 'parent_organisation_id', 'client_id', 'last_marked_as_active_date'];

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
        return $this->hasMany(Project::class)->select('projects.*')
            ->join('project_meta', function ($join) {
                $join->on('project_meta.project_id', '=', 'projects.id');
                $join->where([
                    'project_meta.key' => config('project.meta_keys.billing_level.key'),
                    'project_meta.value' => config('project.meta_keys.billing_level.value.project.key')
                ]);
            });
    }

    public function clientLevelBillingProjects()
    {
        return $this->hasMany(Project::class)->select('projects.*')
            ->join('project_meta', function ($join) {
                $join->on('project_meta.project_id', '=', 'projects.id');
                $join->where([
                    'project_meta.key' => config('project.meta_keys.billing_level.key'),
                    'project_meta.value' => config('project.meta_keys.billing_level.value.client.key')
                ]);
            });
    }

    public function getNextBillingDateAttribute() // In this function nextbilling date comes from client level it can be null.
    {
        $billingFrequencyId = $this->billingDetails->billing_frequency;
        $previousInvoice = invoice::whereNull('project_id')->where('client_id', $this->id)->orderby('sent_on', 'desc')->first();

        if (! $billingFrequencyId && $billingFrequencyId == null) {
            return;
        }

        switch ($billingFrequencyId) {
            case 4: // yearly
                $monthsToAdd = 12;
                break;
            case 2: // monthly
                $monthsToAdd = 1;
                break;
            case 3: // quarterly
                $monthsToAdd = 3;
                break;
            default:
                $monthsToAdd = 1;
        }

        $previousInvoice = $this->invoices()->orderby('sent_on', 'desc')->first();
        if ($previousInvoice) {
            $previousBillingDate = Carbon::parse($previousInvoice->term_end_date)->addDay();
        } else {
            $previousBillingDate = $this->created_at;
        }

        $nextBillingDate = $previousBillingDate->addMonthsNoOverflow($monthsToAdd)->format('Y-m-d');
        $nextBillingDate = Carbon::parse($nextBillingDate);

        return $nextBillingDate->subDays(2)->format('Y-m-d');
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
        return $this->contactPersons()->where('type', config('client.client-contact-person-type.primary-billing-contact'))->first();
    }

    public function secondaryContacts()
    {
        return $this->contactPersons()->where('type', config('client.client-contact-person-type.secondary-billing-contact'));
    }

    public function tertiaryContacts()
    {
        return $this->contactPersons()->where('type', config('client.client-contact-person-type.tertiary-billing-contact'));
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
        return optional($this->country)->currency;
    }

    public function getTaxAmountForTerm($periodStartDate, $periodEndDate, $projects)
    {
        $country = $this->getTypeAttribute();
        if ($country != 'indian') {
            return 0;
        }

        $amount = $this->getBillableAmountWithoutTaxForTerm($periodStartDate, $periodEndDate, $projects);
        $gstPercentage = config('invoice.invoice-details.igst');
        $gstAmount = $amount * floatval($gstPercentage) / 100;

        return $gstAmount;
    }

    public function getBillableHoursForMonth($periodStartDate, $periodEndDate)
    {
        $projects = $this->clientLevelBillingProjects;
        $projects = $projects ?? collect([]);

        $totalHours = $projects->sum(function ($project) use ($periodStartDate, $periodEndDate) {
            return $project->getBillableHoursForMonth($periodStartDate, $periodEndDate);
        });

        if ($totalHours == 0) {
            return;
        }

        return $totalHours;
    }

    public function getBillableAmountWithoutTaxForTerm($periodStartDate, $periodEndDate, $projects)
    {
        $serviceRateTerm = $this->billingDetails->service_rate_term;

        if (! ($serviceRateTerm == 'per_hour')) {
            return $this->billingDetails->service_rates;
        }

        $amount = $projects->sum(function ($project) use ($periodStartDate, $periodEndDate) {
            return round($project->getBillableHoursForMonth($periodStartDate, $periodEndDate) * $this->billingDetails->service_rates, 2);
        });

        return $amount;
    }

    public function getTotalAmountWithTaxForTerm($periodStartDate, $periodEndDate)
    {
        $projects = $this->clientLevelBillingProjects;
        $projects = $projects ?? collect([]);
        $tax = $this->getTaxAmountForTerm($periodStartDate, $periodEndDate, $projects);

        return $this->getBillableAmountWithoutTaxForTerm($periodStartDate, $periodEndDate, $projects) + optional($this->billingDetails)->bank_charges + $tax;
    }

    public function getAmountPaidForTerm(int $monthsToSubtract, $projects)
    {
        // This needs to be updated based on the requirements.
        return 0.00;
    }

    public function getCurrentHoursInProjectsAttribute()
    {
        return $this->projects->sum(function ($project) {
            return $project->current_hours_for_month;
        });
    }

    public function getClientLevelProjectsBillableHoursForInvoice($periodStartDate, $periodEndDate)
    {
        $billableHours = $this->clientLevelBillingProjects->sum(function ($project) use ($periodStartDate, $periodEndDate) {
            return $project->getBillableHoursForMonth($periodStartDate, $periodEndDate);
        });

        if ($billableHours == 0 || $billableHours == null) {
            return 0;
        }

        return $billableHours;
    }

    public function getNextInvoiceNumberAttribute()
    {
        $invoiceService = new InvoiceService();

        return $invoiceService->getInvoiceNumberPreview($this, null, today(), config('project.meta_keys.billing_level.value.client.key'));
    }

    public function getWorkingDaysForTerm()
    {
        $monthStartDate = $this->month_start_date;
        $monthEndDate = $this->month_end_date;

        return $this->getWorkingDays($monthStartDate, $monthEndDate);
    }

    public function getWorkingDays($startDate, $endDate)
    {
        return $endDate->addDay()->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, $startDate);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function scopeInvoiceReadyToSend($query)
    {
        return $query->whereDoesntHave('invoices', function ($query) {
            return $query->whereMonth('sent_on', now(config('constants.timezone.indian')))->whereYear('sent_on', now(config('constants.timezone.indian')));
        })->whereHas('billingDetails', function ($query) {
            return $query->where('billing_date', '<=', today()->format('d'));
        });
    }

    public function getEffortSheetUrlAttribute()
    {
        foreach ($this->clientLevelBillingProjects as $project) {
            if ($project->effort_sheet_url) {
                return $project->effort_sheet_url;
            }
        }
    }

    public function getGoogleChatWebhookUrlAttribute()
    {
        foreach ($this->clientLevelBillingProjects as $project) {
            if ($project->google_chat_webhook_url) {
                return $project->google_chat_webhook_url;
            }
        }
    }

    public function getMonthStartDateAttribute($monthsToSubtract)
    {
        $monthsToSubtract = $monthsToSubtract ?? 0;
        $billingDate = $this->billingDetails->billing_date;

        if ($billingDate == null) {
            return now(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->startOfMonth();
        }

        if (today(config('constants.timezone.indian'))->day < $billingDate) {
            if (today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract + 1)->addDays($billingDate - today(config('constants.timezone.indian'))->day) > today(config('constants.timezone.indian'))->subMonth()->endOfMonth()) {
                return today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract + 1)->endOfMonth();
            }

            return today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract + 1)->addDays($billingDate - today(config('constants.timezone.indian'))->day);
        }

        if (today(config('constants.timezone.indian'))->day >= $billingDate) {
            return today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->startOfMonth()->addDays($billingDate - 1);
        }
    }

    public function getMonthEndDateAttribute($monthsToSubtract)
    {
        $monthsToSubtract = $monthsToSubtract ?? 0;
        $billingDate = $this->billingDetails->billing_date;

        if ($billingDate == null) {
            return now(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->endOfMonth();
        }

        if (today(config('constants.timezone.indian'))->day < $billingDate) {
            if (today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->addDays($billingDate - today(config('constants.timezone.indian'))->day) > today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->endOfMonth()) {
                return today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->endOfMonth();
            }

            return today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->addDays($billingDate - today(config('constants.timezone.indian'))->day - 1);
        }

        if (today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->addMonthsNoOverflow()->startOfMonth()->addDays($billingDate - 2) > today(config('constants.timezone.indian'))->addMonthsNoOverflow()->endOfMonth()) {
            return today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->addMonthsNoOverflow()->endOfMonth();
        }

        return today(config('constants.timezone.indian'))->subMonthsNoOverflow($monthsToSubtract)->addMonthsNoOverflow()->startOfMonth()->addDays($billingDate - 2);
    }

    public function TeamMembersEffortData()
    {
        $startDate = $this->getMonthStartDateAttribute(1);
        $endDate = $this->getMonthEndDateAttribute(1);

        $data = [];
        $clientId = $this->id;
        $users = User::whereHas('projectTeamMembers.project.client', function ($query) use ($clientId) {
            return $query->where('id', $clientId);
        })->get();

        foreach ($users as $user) {
            $projectTeamMemberForUser = $user->projectTeamMembers()->whereHas('project.client', function ($query) use ($clientId) {
                return $query->where('id', $clientId);
            })->whereHas('project.meta', function ($query) {
                return $query->where([
                    'key' => config('project.meta_keys.billing_level.key'),
                    'value' => config('project.meta_keys.billing_level.value.client.key')
                ]);
            })->get();

            if ($projectTeamMemberForUser->isEmpty()) {
                continue;
            }

            $billableHours = $projectTeamMemberForUser->sum(function ($teamMember) use ($startDate, $endDate) {
                return $teamMember->projectTeamMemberEffort->where('added_on', '>=', $startDate)->where('added_on', '<=', $endDate)->sum('actual_effort');
            });

            if ($billableHours == 0) {
                continue;
            }
            $data[$user->name] = [
                'nickname' => $user->nickname,
                'billableHours' => $billableHours
            ];
        }

        return collect($data);
    }

    public function getCcEmailsAttribute()
    {
        $ccEmails = config('invoice.mail.send-invoice.email') . ',';
        if ($this->secondaryContacts->isNotEmpty()) {
            foreach ($this->secondaryContacts as $secondaryContact) {
                $ccEmails .= $secondaryContact->email . ',';
            }
        }

        return substr_replace($ccEmails, '', -1);
    }

    public function getBccEmailsAttribute()
    {
        $bccEmails = '';

        if ($this->tertiaryContacts->isNotEmpty()) {
            foreach ($this->tertiaryContacts as $tertiaryContact) {
                $bccEmails .= $tertiaryContact->email . ',';
            }
        }

        return substr_replace($bccEmails, '', -1);
    }

    public function ledgerAccounts()
    {
        return $this->hasMany(LedgerAccount::class);
    }

    public function ledgerAccountsOnlyCredit()
    {
        return $this->hasMany(LedgerAccount::class)->whereNotNull('credit');
    }

    public function ledgerAccountsOnlyDebit()
    {
        return $this->hasMany(LedgerAccount::class)->whereNotNull('debit');
    }

    public function getClientProjectsTotalLedgerAmount($quarter = null)
    {
        $amount = 0;

        foreach ($this->clientLevelBillingProjects as $project) {
            $amount += $project->getTotalLedgerAmount($quarter);
        }

        return $amount;
    }

    public function getResourceBasedTotalAmount()
    {
        $amount = 0;

        foreach ($this->clientLevelBillingProjects as $project) {
            $amount += $project->getResourceBillableAmount();
        }

        return $amount;
    }

    public function hasCustomInvoiceTemplate()
    {
        $template = config('invoice.templates.invoice.clients.' . $this->name);

        if ($template) {
            return true;
        }

        return false;
    }

    public function getTermStartAndEndDateForInvoice() // Importent function
    {
        $clientBillingDate = $this->billingDetails->billing_date;
        $startDate = $this->getTermStartDate($clientBillingDate);
        $startDate = carbon::parse($startDate);
        $endDate = $this->getTermEndDate($startDate, $clientBillingDate);

        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
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
        $billingFrequencyId = $this->billingDetails->billing_frequency;
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
        $serviceRateTerm = $this->billingDetails->service_rate_term;

        switch ($serviceRateTerm) {
            case 'per_hour':
                $totalAmountInMonth = $this->getAmountForTermPerHour($termStartDate, $termEndDate);

                return  $totalAmountInMonth;
            case 'per_month':
                $totalAmountInMonth = $this->getAmountForTermPerMonth($termStartDate, $termEndDate);

                return  $totalAmountInMonth;
            case 'per_quarter':
                $totalAmountInQuater = $this->getAmountForTermPerQuarterly($termStartDate, $termEndDate);

                return  $totalAmountInQuater;
            case 'per_year':
                $totalAmountInYear = $this->serviceRateFromProjectBillingDetailsTable(); // this need to be correct

                return $totalAmountInYear;
            case 'per_resource':

                return $this->project->getResourceBillableAmount();
            default:

                return $this->billingDetails->service_rates;
        }
    }

    public function amountWithTaxForTerm($termStartDate, $termEndDate)
    {
        $termStartDate = Carbon::parse($termStartDate);
        $termEndDate = Carbon::parse($termEndDate);
        $amount = $this->amountWithoutTaxForTerm($termStartDate, $termEndDate);
        $bankCharge = optional($this->billingDetails)->bank_charges;
        $gstPercentage = config('invoice.invoice-details.igst');
        $totalAmount = $amount + $bankCharge;
        $gst = $totalAmount * floatval($gstPercentage) / 100;

        return round($totalAmount + $gst, 2);
    }

    public function getAmountForTermPerHour($termStartDate, $termEndDate)
    {
        $billingFrequencyId = $this->billingDetails->billing_frequency;
        $termStartDate = Carbon::parse($termStartDate);
        $termEndDate = Carbon::parse($termEndDate);
        $amount = ($this->billingDetails->service_rates * $this->project->getBillableHoursForMonth($termStartDate, $termEndDate));

        if ($billingFrequencyId == 2) { // monthly
            return $amount;
        }
        if ($billingFrequencyId == 3) { // Quarterly
            return $amount * 3;
        }
        if ($billingFrequencyId == 4) { // yearly
            return $amount * 12;
        }

        return $amount;
    }

    public function getAmountForTermPerMonth($termStartDate, $termEndDate)
    {
        $termStartDate = Carbon::parse($termStartDate);
        $termEndDate = Carbon::parse($termEndDate);
        $billingFrequencyId = $this->billingDetails->billing_frequency;
        $totalAmountInMonth = $this->billingDetails->service_rates;
        // $months = $termStartDate->diffInMonths($termEndDate);
        if ($billingFrequencyId == 2) { // monthly
            return  $totalAmountInMonth;
        }
        if ($billingFrequencyId == 3) { // Quarterly
            return  $totalAmountInMonth * 3;
        }
        if ($billingFrequencyId == 4) { // yearly
            return  $totalAmountInMonth * 12;
        }

        return $totalAmountInMonth;
    }

    public function getAmountForTermPerQuarterly($termStartDate, $termEndDate)
    {
        $termStartDate = Carbon::parse($termStartDate);
        $termEndDate = Carbon::parse($termEndDate);
        $totalAmountInQuater = $this->billingDetails->service_rates;
        $billingFrequencyId = $this->billingDetails->billing_frequency;
        // $months = $termStartDate->diffInMonths($termEndDate);

        if ($billingFrequencyId == 3) { // Quarterly
            return  $totalAmountInQuater;
        }
        if ($billingFrequencyId == 4) { // yearly
            return  $totalAmountInQuater * 4;
        }

        return $totalAmountInQuater;
    }

    public function getGstAmount($termStartDate, $termEndDate)
    {
        $amount = $this->amountWithoutTaxForTerm($termStartDate, $termEndDate);
        $gstPercentage = config('invoice.invoice-details.igst');
        $gst = $amount * floatval($gstPercentage) / 100;

        return round($gst, 2);
    }

    public function getTermText($termStartDate, $termEndDate)
    {
        $invoiceService = new InvoiceService();
        $termText = $invoiceService->getTermText($termStartDate, $termEndDate);

        return $termText;
    }
}
