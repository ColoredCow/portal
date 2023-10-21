<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpportunitiesTest extends TestCase
{
	use RefreshDatabase;

	/**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_a_job()
    {
        $this->signIn();
        $response = $this->get('/home');
        $response->assertStatus(200);
   }
}
