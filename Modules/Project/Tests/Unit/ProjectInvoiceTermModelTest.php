<?php

namespace Modules\Project\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Project\Entities\ProjectInvoiceTerm;
use Tests\TestCase;

class ProjectInvoiceTermModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_uuid_is_auto_generated_on_create()
    {
        $term = ProjectInvoiceTerm::factory()->create();

        $this->assertNotNull($term->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $term->uuid
        );
    }

    public function test_uuids_are_unique_per_row()
    {
        $a = ProjectInvoiceTerm::factory()->create();
        $b = ProjectInvoiceTerm::factory()->create();

        $this->assertNotSame($a->uuid, $b->uuid);
    }

    public function test_explicit_uuid_is_not_overwritten()
    {
        $uuid = '22222222-2222-2222-2222-222222222222';
        $term = ProjectInvoiceTerm::factory()->create(['uuid' => $uuid]);

        $this->assertSame($uuid, $term->uuid);
    }

    public function test_route_key_name_is_uuid()
    {
        $this->assertSame('uuid', (new ProjectInvoiceTerm())->getRouteKeyName());
    }
}
