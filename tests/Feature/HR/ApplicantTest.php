<?php

namespace Tests\Feature\HR;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->signIn();
        $response = $this->get('/home');
        $response->assertStatus(200);
    }

    public function saveApplication()
    {
    }
}
