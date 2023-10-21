<?php

namespace Modules\HR\Tests\Unit;

/*
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use Modules\HR\Entities\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpportunitiesTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_job()
    {
        $this->signIn();

        $job = Job::factory()->raw([
            'title' => 'This is a new job'
        ]);

        $response = $this->post(route('recruitment.opportunities.store'), $job);

        $rawJob = Job::first()->get('id');
        $job = json_decode($rawJob);
        $jobId = $job[0]->id;

        $response->assertRedirect('/hr/recruitment/opportunities/' . $jobId . '/edit');
    }

    public function test_fail_creation_without_required_fields()
    {
        $this->signIn();
        $job = Job::factory()->raw([
            "title" => "This is a new job",
            'description' => '',
            'domain' => ''
        ]);

        $response = $this->from('recruitment.opportunities.create')->post(route('recruitment.opportunities.store'), $job);
        $response->assertRedirect('recruitment.opportunities.create');
    }

    public function test_update_job()
    {
        $this->signIn();
        Job::factory()->count(3)->create();
        $jobToUpdate = Job::find(2);
        $jobId = $jobToUpdate->id;
        $updateRoute = route('recruitment.opportunities.update', $jobId);

        $updatedJob = [
            'title' => 'This is updated title.',
            'description' => $jobToUpdate->description,
            'domain' => $jobToUpdate->domain,
            'type' => 'internship',
            'status' => 'closed'
        ];

        if ($updatedJob['type'] == 'volunteer') {
            $updateRoute = route('volunteer.opportunities.update', $jobId);
        }

        $response = $this->patch($updateRoute, $updatedJob);
        $response->assertRedirect('/hr/recruitment/opportunities/' . $jobId . '/edit');
    }

    public function test_fail_update_without_required_fields()
    {
        $this->signIn();
        Job::factory()->count(10)->create();

        $jobToUpdate = Job::find(6);
        $jobId = $jobToUpdate->id;
        $updateRoute = route('recruitment.opportunities.update', $jobId);
        $updatedJob = [
            'title' => '',
            'description' => '',
            'domain' => '',
            'type' => '',
            'status' => ''
        ];

        if ($updatedJob['type'] == 'volunteer') {
            $updateRoute = route('volunteer.opportunities.update', $jobId);
        }

        $response = $this->from('/hr/recruitment/opportunities/' . $jobId . '/edit')->patch($updateRoute, $updatedJob);
        $response->assertRedirect('/hr/recruitment/opportunities/' . $jobId . '/edit');
    }
}
