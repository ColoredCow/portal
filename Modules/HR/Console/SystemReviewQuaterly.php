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
        $employees = Employee::selectRaw('employees.id')->get();

        foreach ($employees as $employee) {
            $assessment = Assessment::create([
                'reviewee_id' => $employee->id,
                'created_at' => Carbon::now(),
            ]);

            IndividualAssessment::create([
                'assessment_id' => $assessment->reviewee_id,
                'reviewer_id' => $assessment->reviewee_id,
                'type' => 'self',
                'status' => 'pending',
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
