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
        $validation = Validator::make($roleTestData, (new RoleRequest())->rules());
        $this->assertFalse($validation->fails());
    }

    public function test_fails_validation_when_name_is_not_provided()
    {
        $roleTestData = [
            'guard_name' => 'web',
            'description' => 'Intern Role',
        ];
        $validation = Validator::make($roleTestData, (new RoleRequest())->rules());
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('name', $validation->errors()->getMessages());
    }

    public function test_fails_validation_when_guard_name_is_not_provided()
    {
        $roleTestData = [
            'name' => 'Intern',
            'description' => 'Intern Role',
        ];
        $validation = Validator::make($roleTestData, (new RoleRequest())->rules());
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('guard_name', $validation->errors()->getMessages());
    }

    public function test_fails_validation_when_description_is_not_provided()
    {
        $roleTestData = [
            'name' => 'Intern',
            'guard_name' => 'web',
        ];
        $validation = Validator::make($roleTestData, (new RoleRequest())->rules());
        $this->assertTrue($validation->fails());
        $this->assertArrayHasKey('description', $validation->errors()->getMessages());
    }
}
