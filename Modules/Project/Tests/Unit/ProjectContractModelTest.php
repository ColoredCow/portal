<?php

namespace Modules\Project\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Project\Entities\ProjectContract;
use Tests\TestCase;

class ProjectContractModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_uuid_is_auto_generated_on_create()
    {
        $contract = ProjectContract::factory()->create();

        $this->assertNotNull($contract->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $contract->uuid
        );
    }

    public function test_uuids_are_unique_per_row()
    {
        $a = ProjectContract::factory()->create();
        $b = ProjectContract::factory()->create();

        $this->assertNotSame($a->uuid, $b->uuid);
    }

    public function test_explicit_uuid_is_not_overwritten()
    {
        $uuid = '11111111-1111-1111-1111-111111111111';
        $contract = ProjectContract::factory()->create(['uuid' => $uuid]);

        $this->assertSame($uuid, $contract->uuid);
    }

    public function test_route_key_name_is_uuid()
    {
        $this->assertSame('uuid', (new ProjectContract())->getRouteKeyName());
    }
}
