<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\Job;
use Tests\TestCase;

class OpportunityStatusTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');
    }

    /**
     * Assert that every value in opportunities-status has a corresponding
     * key in opportunities-status-wp-mapping.
     */
    public function test_every_status_value_has_a_wp_mapping()
    {
        $statusValues = array_values(config('hr.opportunities-status'));
        $wpMappingKeys = array_keys(config('hr.opportunities-status-wp-mapping'));

        foreach ($statusValues as $dbValue) {
            $this->assertContains(
                $dbValue,
                $wpMappingKeys,
                "Database status value '{$dbValue}' is missing from opportunities-status-wp-mapping"
            );
        }
    }

    /**
     * Assert that no two display labels map to the same database value
     * in opportunities-status (i.e. no duplicate db values).
     */
    public function test_no_duplicate_status_db_values()
    {
        $statusValues = array_values(config('hr.opportunities-status'));
        $uniqueValues = array_unique($statusValues);

        $this->assertCount(
            count($uniqueValues),
            $statusValues,
            'opportunities-status config contains duplicate database values'
        );
    }

    /**
     * Assert that the 'Closed' key maps to 'closed' (not 'draft').
     */
    public function test_closed_status_maps_to_closed_db_value()
    {
        $this->assertSame('closed', config('hr.opportunities-status')['Closed']);
    }

    /**
     * Assert that 'closed' has a WP mapping entry.
     */
    public function test_closed_status_has_wp_mapping()
    {
        $this->assertArrayHasKey('closed', config('hr.opportunities-status-wp-mapping'));
    }

    /**
     * Updating a job with status 'published' should persist that value.
     */
    public function test_status_published_persists_on_update()
    {
        $job = Job::factory()->create(['status' => 'draft', 'type' => 'job']);

        $this->patch(
            route('recruitment.opportunities.update', $job->id),
            $this->validJobData(['status' => 'published'])
        );

        $this->assertDatabaseHas('hr_jobs', [
            'id' => $job->id,
            'status' => 'published',
        ]);
    }

    /**
     * Updating a job with status 'draft' should persist that value.
     */
    public function test_status_draft_persists_on_update()
    {
        $job = Job::factory()->create(['status' => 'published', 'type' => 'job']);

        $this->patch(
            route('recruitment.opportunities.update', $job->id),
            $this->validJobData(['status' => 'draft'])
        );

        $this->assertDatabaseHas('hr_jobs', [
            'id' => $job->id,
            'status' => 'draft',
        ]);
    }

    /**
     * Updating a job with status 'closed' should persist 'closed', not 'draft'.
     */
    public function test_closed_status_persists_on_update_not_draft()
    {
        $job = Job::factory()->create(['status' => 'published', 'type' => 'job']);

        $this->patch(
            route('recruitment.opportunities.update', $job->id),
            $this->validJobData(['status' => 'closed'])
        );

        $this->assertDatabaseHas('hr_jobs', [
            'id' => $job->id,
            'status' => 'closed',
        ]);

        $this->assertDatabaseMissing('hr_jobs', [
            'id' => $job->id,
            'status' => 'draft',
        ]);
    }

    /**
     * Updating a job with status 'pending-review' should persist that value.
     */
    public function test_status_pending_review_persists_on_update()
    {
        $job = Job::factory()->create(['status' => 'draft', 'type' => 'job']);

        $this->patch(
            route('recruitment.opportunities.update', $job->id),
            $this->validJobData(['status' => 'pending-review'])
        );

        $this->assertDatabaseHas('hr_jobs', [
            'id' => $job->id,
            'status' => 'pending-review',
        ]);
    }

    /**
     * The edit form should render with the saved status marked as selected.
     */
    public function test_edit_form_shows_saved_status_as_selected()
    {
        $job = Job::factory()->create(['status' => 'published', 'type' => 'job']);

        $response = $this->get(route('recruitment.opportunities.edit', $job->id));

        $response->assertStatus(200);
        $response->assertSee('value="published" selected', false);
    }

    /**
     * The edit form for a job with status 'closed' should show 'closed' selected.
     */
    public function test_edit_form_shows_closed_status_as_selected()
    {
        $job = Job::factory()->create(['status' => 'closed', 'type' => 'job']);

        $response = $this->get(route('recruitment.opportunities.edit', $job->id));

        $response->assertStatus(200);
        $response->assertSee('value="closed" selected', false);
    }

    /**
     * Helper: returns a valid job data array for PATCH requests.
     */
    private function validJobData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Software Engineer',
            'domain' => 'engineering',
            'description' => 'A test job description.',
            'type' => 'job',
            'status' => 'draft',
        ], $overrides);
    }
}
