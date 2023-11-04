<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\Evaluation\Segment;
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
        $this->withoutExceptionHandling();
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

        $segment = Segment::factory()->raw([
            'name' => 'First Segment',
            'round_id' => 1,
        ]);

        $response = $this->post(route('hr.evaluation.segment.store'), $segment);

        $response->assertRedirect(route('hr.evaluation'));
    }
}
