<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends FeatureTest
{

    use RefreshDatabase;
    /** @test */
    public function an_authorised_user_can_see_projects() {
        $this->setUpRolesAndPermissions()
            ->signIn($this->anAuthorizedUser());
        $this->get('/projects')
            ->assertStatus(200);
    }

    /** @test */
    public function an_unauthorised_user_cant_see_projects() {
        $this->withoutExceptionHandling()
            ->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->setUpRolesAndPermissions()
            ->signIn();

        $this->get('/projects');
    }

    /** @test */
    public function a_guest_cant_see_projects() {
        $this->get('/projects')
            ->assertRedirect('login');
    }

    public function anAuthorizedUser() {
        return create(User::class)->assignRole('super-admin');
    }
}
