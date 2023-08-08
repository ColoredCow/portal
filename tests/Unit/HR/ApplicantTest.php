<?php

namespace Tests\Unit\HR;

use Modules\HR\Entities\Applicant;
use Tests\TestCase;

class ApplicantTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_create_applicant()
    {
        $applicant = Applicant::factory()->create();
        $this->assertTrue(isset($applicant->id));
    }
}
