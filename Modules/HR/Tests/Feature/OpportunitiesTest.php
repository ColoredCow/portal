<?php

namespace Modules\HR\Tests\Unit;

/*
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\Job;
use Tests\TestCase;

class OpportunitiesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_job_listing()
    {
        $response = $this->get(route('recruitment.opportunities'));
        $response->assertStatus(200);
    }

    public function test_create_job()
    {
        $job = Job::factory()->raw([
            'title' => 'This is a new job',
        ]);

        $response = $this->post(route('recruitment.opportunities.store'), $job);

        $rawJob = Job::first()->get('id');
        $job = json_decode($rawJob);
        $jobId = $job[0]->id;

        $response->assertRedirect(route('recruitment.opportunities.edit', $jobId));
    }

    public function test_fail_creation_without_required_fields()
    {
        $job = Job::factory()->raw([
            'title' => '',
            'description' => '',
            'domain' => '',
        ]);

        $response = $this->from('recruitment.opportunities.create')->post(route('recruitment.opportunities.store'), $job);
        $response->assertRedirect('recruitment.opportunities.create');
    }

    public function test_update_job()
    {
        Job::factory()->count(3)->create();
        $jobToUpdate = Job::find(2);
        $jobId = $jobToUpdate->id;
        $updateRoute = route('recruitment.opportunities.update', $jobId);

        $updatedJob = [
            'title' => 'This is updated title.',
            'description' => $jobToUpdate->description,
            'domain' => $jobToUpdate->domain,
            'type' => 'internship',
            'status' => 'closed',
        ];

        if ($updatedJob['type'] == 'volunteer') {
            $updateRoute = route('volunteer.opportunities.update', $jobId);
        }

        $response = $this->patch($updateRoute, $updatedJob);
        $response->assertRedirect(route('recruitment.opportunities.edit', $jobId));
    }

    public function test_fail_update_without_required_fields()
    {
        Job::factory()->count(10)->create();

        $jobToUpdate = Job::find(6);
        $jobId = $jobToUpdate->id;
        $updateRoute = route('recruitment.opportunities.update', $jobId);
        $updatedJob = [
            'title' => '',
            'description' => '',
            'domain' => '',
            'type' => '',
            'status' => '',
        ];

        if ($updatedJob['type'] == 'volunteer') {
            $updateRoute = route('volunteer.opportunities.update', $jobId);
        }

        $response = $this->from(route('recruitment.opportunities.edit', $jobId))->patch($updateRoute, $updatedJob);
        $response->assertRedirect(route('recruitment.opportunities.edit', $jobId));
    }
}
