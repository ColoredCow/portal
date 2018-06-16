<?php

namespace Tests\Unit\HR;

use App\Models\HR\Job;
use Tests\TestCase;

class JobTest extends TestCase
{
    /**
     * Test case to check if job creation.
     *
     * @return void
     */
    public function testIsJobCreated()
    {
        $job = factory(Job::class)->create();
        $this->assertTrue(isset($job->id));
    }
}
