<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\HrJobDesignation;
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

        $response = $this->get('hr/designation');
        $response->assertStatus(200);
    }

    public function test_edit_designation()
    {
        $this->withoutExceptionHandling();
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');

        $designation = HrJobDesignation::first();
        $designationId = $designation->id;

        $designation = [
            'designation' => 'First Designation',
            'slug' => 'first-designation',
        ];
    
        $response = $this->get('hr/' . $designationId . '/edit', $designation);
        $response = $this->get('hr/designation');
        $response->assertStatus(200);
    }
}
