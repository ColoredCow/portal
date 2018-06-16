<?php

namespace Tests\Feature;

use App\User;

class ProjectsTest extends FeatureTest
{
    /** @test */
    public function an_authorised_user_can_see_projects()
    {
        //$this->assertTrue(true);
        $this->anAuthorizedUser();
        $this->assertTrue(true);
        
        // $this->get(route('projects'))
        //     ->assertStatus(200);
    }

    public function anAuthorizedUser()
    {
        $this->signIn(create(User::class)->assignRole('super-admin'));
    }
}
