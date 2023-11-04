<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\Evaluation\Segment;
use Modules\HR\Entities\Round;
use Tests\TestCase;

class EvaluationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_segments_listing()
    {
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');
        $response = $this->get(route('hr.evaluation'));
        $response->assertStatus(200);
    }

    public function test_add_segment()
    {
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

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
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

        $round = Round::factory()->create();

        $segment = Segment::factory()->raw([
            'name' => 'First Segment',
            'rounds' => 'Round one',
        ]);

        $response = $this->from(route('hr.evaluation'))
            ->post(route('hr.evaluation.segment.store'), $segment);
        $response->assertStatus(500);
    }

    public function test_update_segment()
    {
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

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
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

        $segmentId = (Segment::factory()->create())->id;

        $updatedSegment = [
            'name' => 'First Segment',
            'round_id' => 'Round one',
        ];

        $response = $this->post(route('hr.evaluation.segment.update', $segmentId), $updatedSegment);
        $response->assertRedirect('/');
    }

    public function test_delete_segment()
    {
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

        $segmentId = Segment::factory()->create()->id;
        $response = $this->post(route('hr.evaluation.segment.delete', $segmentId));
        $response->assertRedirect(route('hr.evaluation'));
    }
}
