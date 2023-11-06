<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\Evaluation\Segment;
use Modules\HR\Entities\Round;
use Tests\TestCase;

class EvaluationTest extends TestCase
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
    public function test_segments_listing()
    {
        $response = $this->get(route('hr.evaluation'));
        $response->assertStatus(200);
    }

    public function test_add_segment()
    {
        $round = Round::factory()->create();

        $segment = Segment::factory()->raw([
            'name' => 'First Segment',
            'rounds' => $round->name,
        ]);

        $response = $this->from(route('hr.evaluation'))
            ->post(route('hr.evaluation.segment.store'), $segment);
        $response->assertRedirect(route('hr.evaluation'));
    }

    public function test_fail_segment_creation_with_invalid_data()
    {
        $segment = [
            'name' => '',
            'rounds' => '',
        ];

        $response = $this->from(route('hr.evaluation'))
            ->post(route('hr.evaluation.segment.store'), $segment);
        $response->assertSessionHasErrors(['name', 'rounds']);
        $response->assertStatus(302);
    }

    public function test_update_segment()
    {
        $roundId = (Round::factory()->create())->id;
        $segmentId = (Segment::factory()->create())->id;

        $updatedSegment = [
            'name' => 'First Segment',
            'round_id' => $roundId,
        ];

        $response = $this->post(route('hr.evaluation.segment.update', $segmentId), $updatedSegment);
        $response->assertRedirect(route('hr.evaluation'));
    }

    public function test_fail_segment_update_with_invalid_data()
    {
        $segmentId = (Segment::factory()->create())->id;

        $updatedSegment = [
            'name' => '',
            'round_id' => null,
        ];

        $response = $this->post(route('hr.evaluation.segment.update', $segmentId), $updatedSegment);
        $response->assertStatus(302);
    }

    public function test_delete_segment()
    {
        $segmentId = Segment::factory()->create()->id;
        $response = $this->post(route('hr.evaluation.segment.delete', $segmentId));
        $response->assertRedirect(route('hr.evaluation'));
    }
}
