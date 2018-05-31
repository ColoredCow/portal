<?php

namespace Tests\Unit\HR;

use Tests\TestCase;
use App\Models\HR\Applicant;

class ApplicantTest extends TestCase
{
    /**
     * Test case to check creation of an applicant
     *
     * @return void
     */
    public function testIsApplicantCreated()
    {
        $applicant = factory(Applicant::class)->create();
        $this->assertTrue(isset($applicant->id));
    }
}
