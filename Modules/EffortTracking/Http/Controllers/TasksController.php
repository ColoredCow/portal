<?php
namespace Modules\EffortTracking\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\EffortTracking\Contracts\TaskServiceContract;
use Modules\EffortTracking\Entities\Task;
use Modules\EffortTracking\Http\Requests\TaskRequest;
use Modules\Project\Entities\Project;

class TasksController extends Controller
{
    protected $service;

    public function __construct(TaskServiceContract $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $projects = $this->service->getProjects();

        return view('efforttracking::task.index', compact('projects'));
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        $task = $this->service->store($validated);

        return response()->json(['message' => 'Task created successfully', 'data' => $task], 200);
    }

    public function show(Project $project)
    {
        $tasks = $this->service->getProjectTasks($project);
        $users = $this->service->getUsers();
        $taskType = $this->service->getTaskType();
        $addTask = $this->service->getAddTask();

        return view('efforttracking::task.show', compact('project', 'tasks', 'users', 'taskType', 'addTask'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        $this->service->update($validated, $task);

        return response()->json(['message' => 'Task updated successfully', 'data' => $task], 200);
    }

    public function destroy(Task $task)
    {
        $isDeleted = $this->service->destroy($task);
        $status = $isDeleted ? 'Task Deleted successfully!' : 'Something went wrong! Please try again';

        return response()->json(['message' => $status], 200);
    }
}
