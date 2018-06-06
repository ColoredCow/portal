<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class FeatureTest extends TestCase
{
    use RefreshDatabase;

    function setUp() {
        parent::setUp();
        $this->setUpRolesAndPermissions();
    }
}
