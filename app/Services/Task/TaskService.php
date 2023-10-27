<?php

namespace App\Services\Task;

use App\Http\Resources\Task\{TaskResource, TaskCollection, PaginationCollection};
use App\Models\Task\Task;
use App\Repositories\Task\TaskRepository;
use App\Traits\IsWeekend;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * The TaskService class provides methods to handle task-related actions.
 */
class TaskService
{
    use IsWeekend;

    /**
     * @var TaskRepository The task repository instance.
     */
    protected $repository;

    /**
     * Create a new TaskService instance.
     *
     * @param  TaskRepository  $repository  The task repository instance.
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Fetches tasks based on the provided search parameters, and paginates the result.
     *
     * @param  array  $data  The search parameters.
     * @return JsonResponse
     */
    public function findAllMatches(array $data): JsonResponse
    {
        $search     = $data['search'] ?? null;
        $perPage    = $data['perPage'] ?? 10;
        $orderBy    = $data['orderBy'] ?? 10;
        $filterDate['startDate'] = $data['startDate'] ?? null;
        $filterDate['deadline']  = $data['deadline'] ?? null;
        $response = $this->repository->findAllMatches($search, $perPage, $orderBy, $filterDate);

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new PaginationCollection($response),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Fetches all tasks.
     *
     * @return JsonResponse
     */
    public function findAll(): JsonResponse
    {
        $reponse = $this->repository->findAll();

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new TaskCollection($reponse),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Fetches a single task based on the provided task.
     *
     * @param  Task  $task  The loaded task.
     * @return JsonResponse
     */
    public function findOne(Task $task): JsonResponse
    {
        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new TaskResource($task),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Creates a new task based on the provided data.
     *
     * @param  array  $data  The task data.
     * @return JsonResponse
     */
    public function create(array $data): JsonResponse
    {
        if ($this->checkIfIsWeekend($data['start_date']) || $this->checkIfIsWeekend($data['deadline'])) {
            return response()->json([
                'error' => 'Dates cannot be weekends.'
            ])->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($this->repository->hasConflict($data)) {
            return response()->json([
                'error' => 'There are already tasks on the dates informed. Enter different dates.'
            ])->setStatusCode(Response::HTTP_CONFLICT);
        }

        $response = $this->repository->create($data);

        if (!$response) {
            return response()->json([
                'error' => 'An error occurred while executing the request.'
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new TaskResource($response),
        ])->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Updates a task based on the provided data and task.
     *
     * @param  array  $data  The new task data.
     * @param  Task  $task  The task loaded.
     * @return JsonResponse
     */
    public function update(array $data, Task $task): JsonResponse
    {
        if (
            (isset($data['start_date']) && $this->checkIfIsWeekend($data['start_date'])) ||
            (isset($data['deadline']) && $this->checkIfIsWeekend($data['deadline']))
        ) {
            return response()->json([
                'error' => 'Dates cannot be weekends.'
            ])->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (isset($data['start_date']) && isset($data['deadline']) && $this->repository->hasConflict($data)) {
            return response()->json([
                'error' => 'There are already tasks on the dates informed. Enter different dates.'
            ])->setStatusCode(Response::HTTP_CONFLICT);
        }

        $response = $this->repository->update($data, $task);

        if (!$response) {
            return response()->json([
                'error' => 'An error occurred while executing the request.'
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new TaskResource($response),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Deletes a task.
     *
     * @param  Task  $task  The task loaded.
     * @return JsonResponse
     */
    public function delete(Task $task): JsonResponse
    {
        $response = $this->repository->delete($task);

        if (!$response) {
            return response()->json([
                'error' => 'An error occurred while executing the request.'
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'The request was successfully executed.',
        ])->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
