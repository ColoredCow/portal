<?php

namespace Modules\HR\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\HR\Entities\Assessment;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\IndividualAssessment;

class SystemReviewQuaterly extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'hr:quarterly-review-system';

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
        $employees = Employee::selectRaw('employees.id, employees.mentor_id, employees.hr_id, employees.manager_id')->get();

        foreach ($employees as $employee) {
            $assessment = Assessment::create([
                'reviewee_id' => $employee->id,
                'created_at' => Carbon::now(),
            ]);

            $reviewers = [
                ['type' => 'self', 'reviewer_id' => $employee->id],
                ['type' => 'mentor', 'reviewer_id' => $employee->mentor_id],
                ['type' => 'hr', 'reviewer_id' => $employee->hr_id],
                ['type' => 'manager', 'reviewer_id' => $employee->manager_id],
            ];

            foreach ($reviewers as $reviewer) {
                if ($reviewer['reviewer_id'] !== null) {
                    IndividualAssessment::create([
                        'assessment_id' => $assessment->id,
                        'reviewer_id' => $reviewer['reviewer_id'],
                        'type' => $reviewer['type'],
                        'status' => 'pending',
                        'created_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}
