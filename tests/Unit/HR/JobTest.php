<?php

namespace Tests\Unit\HR;

use Tests\TestCase;
use App\Models\HR\Round;
use App\Models\HR\Job;

class JobTest extends TestCase
{
    /**
     * Test case to check if job creation
     *
     * @return void
     */
    public function testIsJobCreated()
    {
        $job = factory(Job::class)->create();
        $this->assertTrue(isset($job->id));
    }
}
