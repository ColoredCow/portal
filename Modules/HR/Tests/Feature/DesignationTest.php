<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;
use Tests\TestCase;

class DesignationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_designation_listing()
    {
        $this->withoutExceptionHandling();
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

        $response = $this->get(route('designation'));
        $response->assertStatus(200);
    }

    public function test_add_designation()
    {
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

        $domainId = HrJobDomain::factory()->create()->id;

        $newDesignation = HrJobDesignation::factory()->raw([
            'designation' => 'New Designation',
            'domain' => $domainId,
        ]);

        $response = $this->from(route('designation'))
            ->post(route('designation.store'), $newDesignation);
        $response->assertRedirect(route('designation'));
    }

    public function test_edit_designation()
    {
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

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
}
