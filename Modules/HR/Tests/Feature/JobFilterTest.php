<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\Job;
use Tests\TestCase;

class JobFilterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');
    }

    public function test_published_jobs_appear_in_filter_dropdown()
    {
        $job = Job::factory()->create(['status' => 'published', 'title' => 'Published Developer']);

        $response = $this->get(route('applications.job.index'));

        $response->assertStatus(200);
        $response->assertSee($job->title);
    }

    public function test_closed_jobs_are_excluded_from_filter_dropdown()
    {
        $job = Job::factory()->create(['status' => 'closed', 'title' => 'Closed Engineer Role']);

        $response = $this->get(route('applications.job.index'));

        $response->assertStatus(200);
        $response->assertDontSee($job->title);
    }

    public function test_draft_jobs_are_excluded_from_filter_dropdown()
    {
        $job = Job::factory()->create(['status' => 'draft', 'title' => 'Draft Intern Position']);

        $response = $this->get(route('applications.job.index'));

        $response->assertStatus(200);
        $response->assertDontSee($job->title);
    }

    public function test_published_jobs_are_sorted_alphabetically_in_filter_dropdown()
    {
        Job::factory()->create(['status' => 'published', 'title' => 'Zebra Engineer']);
        Job::factory()->create(['status' => 'published', 'title' => 'Alpha Developer']);
        Job::factory()->create(['status' => 'published', 'title' => 'Mid Designer']);

        $response = $this->get(route('applications.job.index'));

        $response->assertStatus(200);

        $content = $response->getContent();
        $alphaPos = strpos($content, 'Alpha Developer');
        $midPos = strpos($content, 'Mid Designer');
        $zebraPos = strpos($content, 'Zebra Engineer');

        $this->assertLessThan($midPos, $alphaPos, 'Alpha Developer should appear before Mid Designer');
        $this->assertLessThan($zebraPos, $midPos, 'Mid Designer should appear before Zebra Engineer');
    }

    public function test_scope_published_returns_only_published_jobs()
    {
        Job::factory()->create(['status' => 'published']);
        Job::factory()->create(['status' => 'published']);
        Job::factory()->create(['status' => 'closed']);
        Job::factory()->create(['status' => 'draft']);

        $publishedJobs = Job::published()->get();

        $this->assertCount(2, $publishedJobs);
        $publishedJobs->each(function ($job) {
            $this->assertEquals('published', $job->status);
        });
    }

    public function test_scope_order_by_title_returns_jobs_sorted_alphabetically()
    {
        Job::factory()->create(['status' => 'published', 'title' => 'Zebra Role']);
        Job::factory()->create(['status' => 'published', 'title' => 'Alpha Role']);
        Job::factory()->create(['status' => 'published', 'title' => 'Mid Role']);

        $jobs = Job::published()->orderByTitle()->get();

        $this->assertEquals('Alpha Role', $jobs->first()->title);
        $this->assertEquals('Zebra Role', $jobs->last()->title);
    }
}
