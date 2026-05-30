<?php

namespace Modules\Prospect\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectEngagement;
use Tests\TestCase;

class ProspectEngagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_persists_a_prospect_engagement()
    {
        $engagement = factory(ProspectEngagement::class)->create([
            'short_descriptor' => 'cotton-traceability',
            'year' => 2026,
        ]);

        $this->assertDatabaseHas('prospect_engagements', [
            'id' => $engagement->id,
            'short_descriptor' => 'cotton-traceability',
            'year' => 2026,
        ]);
    }

    public function test_stage_defaults_to_inquiry()
    {
        $prospect = factory(Prospect::class)->create();

        $engagement = ProspectEngagement::create([
            'prospect_id' => $prospect->id,
            'short_descriptor' => 'website-cms',
            'year' => 2026,
        ]);

        $this->assertEquals('inquiry', $engagement->fresh()->stage);
    }

    public function test_it_belongs_to_a_prospect()
    {
        $engagement = factory(ProspectEngagement::class)->create();

        $this->assertInstanceOf(Prospect::class, $engagement->prospect);
    }

    public function test_a_prospect_has_many_engagements()
    {
        $prospect = factory(Prospect::class)->create();
        factory(ProspectEngagement::class)->create(['prospect_id' => $prospect->id]);
        factory(ProspectEngagement::class)->create(['prospect_id' => $prospect->id]);

        $this->assertCount(2, $prospect->fresh()->engagements);
    }

    public function test_drift_flag_casts_to_boolean()
    {
        $engagement = factory(ProspectEngagement::class)->create(['drift_flag' => true]);

        $this->assertTrue($engagement->fresh()->drift_flag);
    }
}
