<?php

namespace Tests\Unit\HR;

use Tests\TestCase;
use App\Models\HR\Round;

class RoundTest extends TestCase
{
    /**
     * Test for round creation.
     *
     * @return void
     */
    public function testIsRoundCreated()
    {
        $round = factory(Round::class)->create();
        $this->assertTrue(isset($round->id));
    }
}
