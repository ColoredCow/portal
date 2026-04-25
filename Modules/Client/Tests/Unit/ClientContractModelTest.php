<?php

namespace Modules\Client\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Client\Entities\ClientContract;
use Tests\TestCase;

class ClientContractModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_uuid_is_auto_generated_on_create()
    {
        $contract = ClientContract::factory()->create();

        $this->assertNotNull($contract->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $contract->uuid
        );
    }

    public function test_uuids_are_unique_per_row()
    {
        $a = ClientContract::factory()->create();
        $b = ClientContract::factory()->create();

        $this->assertNotSame($a->uuid, $b->uuid);
    }

    public function test_explicit_uuid_is_not_overwritten()
    {
        $uuid = '11111111-1111-1111-1111-111111111111';
        $contract = ClientContract::factory()->create(['uuid' => $uuid]);

        $this->assertSame($uuid, $contract->uuid);
    }

    public function test_route_key_name_is_uuid()
    {
        $this->assertSame('uuid', (new ClientContract())->getRouteKeyName());
    }
}
