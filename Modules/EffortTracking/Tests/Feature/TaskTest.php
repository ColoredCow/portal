<?php

namespace Modules\EffortTracking\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Modules\Project\Entities\Project;
use Modules\User\Entities\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_redirects_guests_to_login()
    {
        $this->get(route('task.index'))->assertRedirect(route('login'));
    }

    #[Test]
    public function it_shows_the_task_list_to_authenticated_users()
    {
        $this->signIn();

        $this->get(route('task.index'))->assertSuccessful();
    }

    #[Test]
    public function it_stores_a_task_and_returns_json()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $this->be($user);

        $this->postJson(route('task.store'), [
            'name' => 'Write unit tests',
            'worked_on' => '2026-06-10',
            'type' => 'development',
            'asignee_id' => $user->id,
            'project_id' => $project->id,
            'estimated_effort' => 2,
            'effort_spent' => 1.5,
            'comment' => '',
        ])->assertOk()->assertJsonFragment(['message' => 'Task created successfully']);
    }
}
