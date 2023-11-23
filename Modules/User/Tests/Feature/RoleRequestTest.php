<?php

namespace Modules\User\Tests\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Modules\User\Http\Requests\RoleRequest;
use Tests\TestCase;

class RoleRequestTest extends TestCase
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

    public function test_roles_listing()
    {
        $response = $this->get(route('user.role-all'));
        $response->assertStatus(200);
    }
   
    public function create_user_role()
    {
        $roleTestData = [
            'name' => 'Test Role',
            'guard_name' => 'web',
            'description' => 'Test Role Description',
        ];
        $response = $this->from(route('user.role-all'))
            ->post(route('roles.add-roles'), $roleTestData);
        $response->assertSessionDoesntHaveErrors(['name', 'guard_name', 'description']);
        $response->assertRedirect(route('user.role-all'));
    }

    public function test_fails_validation_when_name_is_not_provided()
    {
        $roleTestData = [
            'guard_name' => 'web',
            'description' => 'Test Role Description',
        ];

        $validator = Validator::make($roleTestData, (new RoleRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->getMessages());
    }
   
    public function test_fails_validation_when_guard_name_is_not_provided()
    {
        $roleTestData = [
            'name' => 'Test Role',
            'description' => 'Test Role Description',
        ];

        $validator = Validator::make($roleTestData, (new RoleRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('guard_name', $validator->errors()->getMessages());
    }
   
    public function test_fails_validation_when_description_is_not_provided()
    {
        $roleTestData = [
            'name' => 'Test Role',
            'guard_name' => 'web',
        ];
        $validator = Validator::make($roleTestData, (new RoleRequest())->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('description', $validator->errors()->getMessages());
    }
}
