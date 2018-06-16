<?php

namespace Tests\Unit\HR;

use App\Models\HR\Round;
use Tests\TestCase;

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
