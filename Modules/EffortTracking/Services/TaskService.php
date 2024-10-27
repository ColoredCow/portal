<?php
namespace Modules\EffortTracking\Services;

use Modules\EffortTracking\Contracts\TaskServiceContract;
use Modules\EffortTracking\Entities\Task;
use Modules\Project\Entities\Project;
use Modules\User\Entities\User;

class TaskService implements TaskServiceContract
{
    public function store($data)
    {
        return Task::create($data);
    }

    public function update($data, $task)
    {
        return $task->update($data);
    }

    public function destroy($task)
    {
        return $task->delete();
    }
    public function getUsers()
    {
        return User::all();
    }

    public function getProjects()
    {
        return Project::all();
    }

    public function getProjectTasks(Project $project)
    {
        $tasks = $project->tasks;
        foreach ($tasks as $task) {
            $task->btn_text = 'Update';
            $task->update_action = route('task.update', $task);
            $task->delete_action = route('task.destroy', $task);
            $task->note = $task->comment ? 'View Note' : 'Add Note';
            $task->class = '';
        }

        return $tasks;
    }

    public function getTaskType()
    {
        return [
            'research',
            'design',
            'development',
            'qa',
            'review',
            'devops',
        ];
    }
    public function getAddTask()
    {
        return (object) [
            'name' => '',
            'type' => '',
            'estimated_effort' => '',
            'asignee_id' => '',
            'effort_spent' => '',
            'worked_on' => '',
            'update_action' => '',
            'delete_action' => '',
            'class' => 'd-none',
            'btn_text' => '',
            'comment' => '',
            'note' => 'Add Note',
        ];
    }
}
