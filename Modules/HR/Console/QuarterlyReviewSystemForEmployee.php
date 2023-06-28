<?php

namespace Modules\HR\Console;

use Illuminate\Console\Command;
use Modules\HR\Entities\Assessment;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\IndividualAssessment;

class QuarterlyReviewSystemForEmployee extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'employee:quarterly-review-system-for-employee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates quarterly assessment cards for employees.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $employees = Employee::Where('staff_type', 'employee')->selectRaw('employees.id, employees.mentor_id, employees.hr_id, employees.manager_id')->get();

        foreach ($employees as $employee) {
            $assessment = $this->createAssessment($employee);

            $reviewers = $this->getReviewers($employee);

            $this->createIndividualAssessments($assessment, $reviewers);
        }
    }

    private function createAssessment($employee)
    {
        return Assessment::create([
            'reviewee_id' => $employee->id,
            'created_at' => now(),
        ]);
    }

    private function getReviewers($employee)
    {
        $reviewers = [
            ['type' => 'self', 'reviewer_id' => $employee->id],
            ['type' => 'mentor', 'reviewer_id' => $employee->mentor_id],
            ['type' => 'hr', 'reviewer_id' => $employee->hr_id],
            ['type' => 'manager', 'reviewer_id' => $employee->manager_id],
        ];

        return array_filter($reviewers, fn ($reviewer) => $reviewer['reviewer_id'] !== null);
    }

    private function createIndividualAssessments($assessment, $reviewers)
    {
        foreach ($reviewers as $reviewer) {
            IndividualAssessment::create([
                'assessment_id' => $assessment->id,
                'reviewer_id' => $reviewer['reviewer_id'],
                'type' => $reviewer['type'],
                'status' => 'pending',
                'created_at' => now(),
            ]);
        }
    }
}
