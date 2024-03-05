<?php

namespace Modules\HR\Entities;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrEmployeeFactory;
use Modules\Salary\Entities\EmployeeSalary;
use Modules\User\Entities\User;

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

    public function hrJobDomain()
    {
        return $this->belongsTo(HrJobDomain::class, 'domain_id');
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
}
