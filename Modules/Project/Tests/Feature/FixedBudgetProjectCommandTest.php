<?php

namespace Modules\Project\Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Modules\Client\Entities\Client;
use Modules\Project\Emails\FixedBudgetProjectMail;
use Modules\Project\Entities\Project;
use Modules\User\Entities\User;
use Tests\TestCase;

class FixedBudgetProjectCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_queues_reminder_to_key_account_manager_for_fixed_budget_project_ending_in_five_days()
    {
        Mail::fake();

        $kam = User::factory()->create();
        $client = Client::factory()->create(['key_account_manager_id' => $kam->id]);
        $project = Project::factory()->create([
            'client_id' => $client->id,
            'type' => 'fixed-budget',
            'status' => 'active',
            'end_date' => Carbon::today(config('constants.timezone.indian'))->addDays(5),
        ]);

        $this->artisan('project:fixed-budget-project')->assertExitCode(0);

        Mail::assertQueued(FixedBudgetProjectMail::class, function ($mail) use ($kam, $project) {
            return collect($mail->projectData)->contains(function ($row) use ($kam, $project) {
                return $row['email'] === $kam->email
                    && $row['project']->id === $project->id;
            });
        });
    }

    public function test_command_does_not_remind_for_fixed_budget_project_not_ending_in_five_days()
    {
        Mail::fake();

        $kam = User::factory()->create();
        $client = Client::factory()->create(['key_account_manager_id' => $kam->id]);
        Project::factory()->create([
            'client_id' => $client->id,
            'type' => 'fixed-budget',
            'status' => 'active',
            'end_date' => Carbon::today(config('constants.timezone.indian'))->addDays(10),
        ]);

        $this->artisan('project:fixed-budget-project')->assertExitCode(0);

        Mail::assertNotQueued(FixedBudgetProjectMail::class);
    }
}
