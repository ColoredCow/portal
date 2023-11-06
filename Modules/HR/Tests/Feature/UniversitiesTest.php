<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\University;
use Modules\HR\Entities\UniversityAlias;
use Modules\HR\Entities\UniversityContact;
use Tests\TestCase;

class UniversitiesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpRolesAndPermissions();
        $this->signIn('super-admin');
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_universities_listing()
    {
        $response = $this->get(route('universities.index'));
        $response->assertStatus(200);
    }

    public function test_add_a_university()
    {
        $universityData = $this->universityData();
        $response = $this->post(route('universities.store'), $universityData);
        $universityId = University::where('name', $universityData['name'])->firstOrFail()->id;
        $response->assertRedirect(route('universities.edit', $universityId));
    }

    public function test_fail_to_add_a_university()
    {
        $universityData = $this->universityData();
        $universityData['name'] = null;
        $response = $this->post(route('universities.store'), $universityData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_add_alias_to_university()
    {
        $university = University::factory()->create();
        $aliasData = UniversityAlias::factory()->raw($this->aliasData($university));

        $response = $this->post(route('universities.aliases.store'), $aliasData);
        $response->assertStatus(200);
    }

    public function test_fail_to_add_alias_to_university()
    {
        $university = University::factory()->create();
        $alias = $this->aliasData($university);
        $alias['name'] = null;
        $aliasData = UniversityAlias::factory()->raw($alias);

        $response = $this->post(route('universities.aliases.store'), $aliasData);
        $response->assertStatus(302);
    }

    public function test_add_contact_to_university()
    {
        $university = University::factory()->create();
        $contactData = UniversityContact::factory()->raw($this->contactData($university));

        $response = $this->post(route('universities.contacts.store'), $contactData);
        $response->assertStatus(200);
    }

    public function test_fail_to_add_contact_to_university()
    {
        $university = University::factory()->create();
        $contact = $this->contactData($university);
        $contact['name'] = null;
        $contactData = UniversityContact::factory()->raw($contact);

        $response = $this->post(route('universities.contacts.store'), $contactData);
        $response->assertStatus(302);
    }

    public function test_edit_a_university()
    {
        $universityData = $this->universityData();
        $universityId = University::factory()->create()->id;

        $response = $this->from(route('universities.edit', $universityId))
            ->put(route('universities.update', $universityId), $universityData);
        $response->assertRedirect(route('universities.edit', $universityId));
    }

    public function test_fail_to_edit_a_university()
    {
        $universityData = $this->universityData();
        $universityData['name'] = null;
        $universityId = University::factory()->create()->id;

        $response = $this->from(route('universities.edit', $universityId))
            ->put(route('universities.update', $universityId), $universityData);
        $response->assertStatus(302);
    }

    public function test_edit_a_university_contact()
    {
        $university = University::factory()->create();
        $contact = UniversityContact::factory()->create(['hr_university_id' => $university->id]);

        $contactData = $this->contactData($university);
        $response = $this->from(route('universities.edit', $university->id))
            ->put(route('universities.contacts.update', $contact->id), $contactData);

        $response->assertStatus(200);
    }

    public function test_fail_to_edit_a_university_contact()
    {
        $university = University::factory()->create();
        $contact = UniversityContact::factory()->create(['hr_university_id' => $university->id]);

        $contactData = $this->contactData($university);
        $contactData['name'] = null;
        $response = $this->from(route('universities.edit', $university->id))
            ->put(route('universities.contacts.update', $contact->id), $contactData);

        $response->assertStatus(302);
    }

    public function test_edit_a_university_alias()
    {
        $university = University::factory()->create();
        $alias = UniversityAlias::factory()->create(['hr_university_id' => $university->id]);

        $aliasData = $this->aliasData($university);
        $response = $this->from(route('universities.edit', $university->id))
            ->put(route('universities.aliases.update', $alias->id), $aliasData);

        $response->assertStatus(200);
    }

    public function test_fail_to_edit_a_university_alias()
    {
        $university = University::factory()->create();
        $alias = UniversityAlias::factory()->create(['hr_university_id' => $university->id]);

        $aliasData = $this->aliasData($university);
        $aliasData['name'] = null;
        $response = $this->from(route('universities.edit', $university->id))
            ->put(route('universities.aliases.update', $alias->id), $aliasData);

        $response->assertStatus(302);
    }

    public function test_delete_a_university()
    {
        $universityId = University::factory()->create()->id;
        $response = $this->from(route('universities.index'))
            ->delete(route('universities.destroy', $universityId));
        $response->assertRedirect(route('universities.index'));
    }

    public function test_delete_a_university_alias()
    {
        $alias = UniversityAlias::factory()->create();
        $aliasId = $alias->id;
        $universityId = $alias->university->id;
        $response = $this->from(route('universities.edit', $universityId))
            ->delete(route('universities.aliases.destroy', $aliasId));
        $response->assertStatus(200);
    }

    public function test_delete_a_university_contact()
    {
        $contact = UniversityContact::factory()->create();
        $contactId = $contact->id;
        $universityId = $contact->university->id;
        $response = $this->from(route('universities.edit', $universityId))
            ->delete(route('universities.contacts.destroy', $contactId));
        $response->assertStatus(200);
    }

    private function universityData()
    {
        return [
            'name' => 'Imperial College London',
            'address' => 'London, England',
        ];
    }

    private function contactData($university)
    {
        return [
            'name' => 'Sebastian',
            'hr_university_id' => $university->id,
            'email' => 'abc@def.com',
            'designation' => 'Assistant Professor',
            'phone' => 1234567890,
        ];
    }

    private function aliasData($university)
    {
        return [
            'name' => 'Alias 1',
            'hr_university_id' => $university->id,
        ];
    }
}
