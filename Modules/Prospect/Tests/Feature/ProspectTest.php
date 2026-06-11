<?php

namespace Modules\Prospect\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Entities\User;
use Tests\TestCase;

class ProspectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_redirects_guests_to_login()
    {
        $this->get(route('prospect.index'))->assertRedirect(route('login'));
    }

    /** @test */
    public function it_shows_the_prospect_list_to_authenticated_users()
    {
        $this->signIn();

        $this->get(route('prospect.index'))->assertSuccessful();
    }

    /** @test */
    public function it_creates_a_new_prospect_and_redirects_to_the_index()
    {
        $user = User::factory()->create();
        $this->be($user);

        $this->post(route('prospect.store'), [
            'poc_user_id' => $user->id,
            'customer_type' => 'new',
            'org_name' => 'Acme Corp',
        ])->assertRedirect(route('prospect.index'));

        $this->assertDatabaseHas('prospects', [
            'organization_name' => 'Acme Corp',
            'poc_user_id' => $user->id,
        ]);
    }
}
