<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;
use Tests\TestCase;

class DesignationTest extends TestCase
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
    public function test_designation_listing()
    {
        $response = $this->get(route('designation'));
        $response->assertStatus(200);
    }

    public function test_add_designation()
    {
        $domainId = HrJobDomain::factory()->create()->id;

        $newDesignation = HrJobDesignation::factory()->raw([
            'designation' => 'New Designation',
            'domain' => $domainId,
        ]);

        $response = $this->from(route('designation'))
            ->post(route('designation.store'), $newDesignation);
        $response->assertRedirect(route('designation'));
    }

    public function test_fail_to_add_designation()
    {
        $domainId = HrJobDomain::factory()->create()->id;

        $newDesignation = HrJobDesignation::factory()->raw([
            'designation' => '',
            'domain' => '',
        ]);

        $response = $this->from(route('designation'))
            ->post(route('designation.store'), $newDesignation);
        $response->assertRedirect(route('designation'));
    }

    public function test_edit_designation()
    {
        $domainId = HrJobDomain::factory()->create()->id;
        $designation = HrJobDesignation::factory()->create();
        $designationId = $designation->id;
        $designation = [
            'designation' => 'First Designation',
            'domain' => $domainId,
        ];

        $response = $this->from(route('designation'))->post(route('designation.edit', $designationId), $designation);
        $response->assertRedirect(route('designation'));
    }

    public function test_fail_to_edit_designation()
    {
        $domainId = HrJobDomain::factory()->create()->id;
        $designation = HrJobDesignation::factory()->create();
        $designationId = $designation->id;
        $designation = [
            'designation' => '',
            'domain' => '',
        ];

        $response = $this->from(route('designation'))->post(route('designation.edit', $designationId), $designation);
        $response->assertRedirect(route('designation'));
    }

    public function test_delete_designation()
    {
        $domainId = HrJobDomain::factory()->create()->id;
        $designationIdToDelete = HrJobDesignation::first()->id;
        $response = $this->from(route('designation'))->post(route('designation.delete', $designationIdToDelete));
        $response->assertRedirect(route('designation'));
    }
}
