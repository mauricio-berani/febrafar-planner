<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateRequest, UpdateRequest};
use App\Http\Requests\Common\MatchRequest;
use App\Models\Task\Task;
use App\Services\Task\TaskService;
use Illuminate\Http\JsonResponse;

/**
 * Class TaskController
 *
 * This controller handles incoming HTTP requests related to task type management,
 * delegating the business logic to the TaskService.
 *
 * @package App\Http\Controllers\Api\Task
 */
class TaskController extends Controller
{

    /**
     * The task service instance.
     *
     * @var TaskService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param TaskTypeService $service The task service instance.
     */
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle a request to find all matching task based on certain criteria.
     *
     * @param MatchRequest $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function findAllMatches(MatchRequest $request): JsonResponse
    {
        $this->authorize(__FUNCTION__, Task::class);
        $data = $request->validated();

        return $this->service->findAllMatches($data);
    }

    /**
     * Handle a request to find all tasks.
     *
     * @return JsonResponse The JSON response for the client.
     */
    public function findAll(): JsonResponse
    {
        $this->authorize(__FUNCTION__, Task::class);

        return $this->service->findAll();
    }

    /**
     * Handle a request to find a single task.
     *
     * @param Task $task The task task to find.
     * @return JsonResponse The JSON response for the client.
     */
    public function findOne(Task $task): JsonResponse
    {
        $this->authorize(__FUNCTION__, Task::class);

        return $this->service->findOne($task);
    }

    /**
     * Handle a request to create a new task.
     *
     * @param CreateRequest $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $this->authorize(__FUNCTION__, TaskTask::class);
        $data = $request->validated();

        return $this->service->create($data);
    }

    /**
     * Handle a request to update an existing task.
     *
     * @param UpdateRequest $request The incoming request.
     * @param Task $task The task to update.
     * @return JsonResponse The JSON response for the client.
     */
    public function update(UpdateRequest $request, Task $task): JsonResponse
    {
        $this->authorize(__FUNCTION__, Task::class);
        $data = $request->validated();

        return $this->service->update($data, $task);
    }

    /**
     * Handle a request to delete an existing task.
     *
     * @param Task $task The task to delete.
     * @return JsonResponse The JSON response for the client.
     */
    public function delete(Task $task): JsonResponse
    {
        $this->authorize(__FUNCTION__, Task::class);

        return $this->service->delete($task);
    }
}
