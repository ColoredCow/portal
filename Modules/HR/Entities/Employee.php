<?php

namespace Modules\HR\Entities;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrEmployeeFactory;
use Modules\Salary\Entities\EmployeeSalary;
use Modules\User\Entities\User;
use App\Services\EmployeeService;
use Modules\HR\Http\Controllers\EmployeeController;
use Modules\Invoice\Services\CurrencyService;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['joined_on'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hrJobDesignation()
    {
        return $this->belongsTo(HrJobDesignation::class, 'designation_id');
    }

    public function scopeStatus($query, $status)
    {
        if ($status == 'current') {
            return $query->wherehas('user');
        }

        return $query->whereDoesntHave('user');
    }

    public function scopeStaffType($query, $staffName)
    {
        return $query->where('staff_type', $staffName);
    }

    public function scopeFilterByName($query, $name)
    {
        return $query->where('employees.name', 'LIKE', "%{$name}%");
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('user_id');
    }

    public function getEmploymentDurationAttribute()
    {
        if (is_null($this->user_id)) {
            return;
        }
        $now = now();

        return $this->joined_on->diff($now)->days < 1 ? '0 days' : $this->joined_on->diffForHumans($now, 1);
    }

    /**
     * Get the projects for the employees.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('contribution_type');
    }

    public function scopeApplyFilters($query, $filters)
    {
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'status':
                    $query->status($value);
                    break;
                case 'employee_name':
                    $query->filterByName($value);
                    break;
                case 'staff_type':
                    $query->staffType($value);
                    break;
            }
        }

        return $query;
    }

    public function employeeSalaries()
    {
        return $this->hasMany(EmployeeSalary::class);
    }

    public function getCurrentSalary()
    {
        return $this->employeeSalaries()->latest('commencement_date')->first();
    }

    public function getPreviousSalary()
    {
        return $this->employeeSalaries()->latest('commencement_date')->skip(1)->first();
    }

    public function getLatestSalaryPercentageIncrementAttribute()
    {
        $currentCtc = optional($this->getCurrentSalary())->ctc_aggregated ?? 0;
        $previousCtc = optional($this->getPreviousSalary())->ctc_aggregated ?? 0;

        if ($currentCtc == 0 || $previousCtc == 0) {
            return 0;
        }

        $percentageIncrementInFloat = (($currentCtc - $previousCtc) / $previousCtc) * 100;

        return round($percentageIncrementInFloat, 2);
    }

    public function getFtes($startDate, $endDate)
    {
        $fte = 0;
        $fteAmc = 0;
        foreach ($this->user->projectTeamMembers()->with('project')->get() as $projectTeamMember) {
            if (! $projectTeamMember->project->is_amc) {
                $fte += $projectTeamMember->getFte($startDate, $endDate);
            }
            if ($projectTeamMember->project->is_amc) {
                $fteAmc += $projectTeamMember->getFte($startDate, $endDate);
            }
        }

        return ['main' => $fte, 'amc' => $fteAmc];
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'reviewee_id');
    }

    public function getOverallStatusAttribute()
    {
        $assessments = $this->assessments()
            ->whereRaw('YEAR(assessments.created_at) = YEAR(CURDATE())')
            ->whereRaw('QUARTER(assessments.created_at) = QUARTER(CURDATE())')
            ->first();
        $overallStatus = null;
        if ($assessments && $assessments->individualAssessments->isNotEmpty()) {
            $individualStatuses = $assessments->individualAssessments->pluck('status')->unique();

            if ($individualStatuses->count() === 1) {
                $overallStatus = $individualStatuses->first();
            } else {
                $overallStatus = 'in-progress';
            }
        }

        return $overallStatus;
    }

    public static function newFactory()
    {
        return new HrEmployeeFactory();
    }

    public function getCurrentMonthProfitabilityAttribute($employee) {
        $employeeService = new EmployeeService();
        $data = $employeeService->fetchEmployeeEarnings($employee->id);
    
        $totalAmount = 0;
    
        foreach ($data['employees'] as &$employeeData) {
            $currency = $employeeData['currency'];
            $rateAfterConversion =  $this->getTotalServiceRates($currency);

            $totalAmountAfterConversion = $rateAfterConversion * $employeeData['actual_effort'] * $employeeData['service_rates'];
            
            $employeeData['rate_after_conversion'] = $rateAfterConversion;
            $employeeData['total_amount_after_conversion'] = $totalAmountAfterConversion;
            
            $totalAmount += $totalAmountAfterConversion;
        }
    
        return  number_format($totalAmount, 2);
    }
    

    public function getTotalServiceRates($currency) {
        $conversionRates = new CurrencyService();
        $conversionRate = $conversionRates->getAllCurrentRatesInINR();
        $initial = config('invoice.currency_initials');
        $service_rates_value = 0;

        switch (strtoupper($currency)) {
            case $initial['usd']:
                $service_rates_value = $conversionRate['USDINR'];
                break;

            case $initial['eur']:
                $service_rates_value = round(($conversionRate['USDINR']) / ($conversionRate['USDEUR']), 2);
                break;

            case $initial['swi']:
                $service_rates_value = round(($conversionRate['USDINR']) / ($conversionRate['USDCHF']), 2);
                break;
        }

       return $service_rates_value;
    }
}
