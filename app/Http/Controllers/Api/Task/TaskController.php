<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\{CreateRequest, UpdateRequest, MatchRequest};
use App\Models\Task\Task;
use App\Services\Task\TaskService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Tasks",
 *     description="APIs related to task management"
 * )
 *
 * @OA\Schema(
 *     schema="Task",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="Task ID"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Task title"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Task description"
 *     ),
 *     @OA\Property(
 *         property="deadline",
 *         type="string",
 *         format="date",
 *         description="Task deadline"
 *     ),
 *     @OA\Property(
 *         property="start_date",
 *         type="string",
 *         format="date",
 *         description="Task start date"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Task status",
 *         enum={"pending", "completed", "in_progress"}
 *     ),
 *     @OA\Property(
 *         property="task_type_id",
 *         type="string",
 *         format="uuid",
 *         description="Task Type ID"
 *     )
 * )
 *
 * Class TaskController
 *
 * This controller handles incoming HTTP requests related to task management,
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
     * @OA\Get(
     *     path="/api/tasks/matches",
     *     summary="Find all tasks that match certain criteria",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=true,
     *         description="Title to match",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=true,
     *         description="Status to match",
     *         @OA\Schema(
     *             type="string",
     *             enum={"pending", "completed", "in_progress"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of matching tasks successfully retrieved",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Task")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * Handle a request to find all matching task based on certain criteria.
     *
     * @param MatchRequest $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function findAllMatches(MatchRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->service->findAllMatches($data);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Retrieve the list of tasks",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all tasks successfully retrieved",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Task")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * Handle a request to find all tasks.
     *
     * @return JsonResponse The JSON response for the client.
     */
    public function findAll(): JsonResponse
    {
        return $this->service->findAll();
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{task}",
     *     summary="Retrieve a single task",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task to retrieve",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task successfully retrieved",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     *
     * Handle a request to find a single task.
     *
     * @param Task $task The task task to find.
     * @return JsonResponse The JSON response for the client.
     */
    public function findOne(Task $task): JsonResponse
    {
        return $this->service->findOne($task);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Create a new task",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Task creation data",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 description="Title of the new task"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Description of the new task"
     *             ),
     *             @OA\Property(
     *                 property="deadline",
     *                 type="string",
     *                 format="date",
     *                 description="Deadline of the new task"
     *             ),
     *             @OA\Property(
     *                 property="start_date",
     *                 type="string",
     *                 format="date",
     *                 description="Start date of the new task"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="Status of the new task",
     *                 enum={"pending", "completed", "in_progress"}
     *             ),
     *             @OA\Property(
     *                 property="task_type_id",
     *                 type="string",
     *                 format="uuid",
     *                 description="ID of the task type for the new task"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task successfully created",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input data"
     *     )
     * )
     *
     * @param CreateRequest $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->service->create($data);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{task}",
     *     summary="Update an existing task",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task to update",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated task data",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 description="Updated title of the task"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Updated description of the task"
     *             ),
     *             @OA\Property(
     *                 property="deadline",
     *                 type="string",
     *                 format="date",
     *                 description="Updated deadline of the task"
     *             ),
     *             @OA\Property(
     *                 property="start_date",
     *                 type="string",
     *                 format="date",
     *                 description="Updated start date of the task"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="Updated status of the task",
     *                 enum={"pending", "completed", "in_progress"}
     *             ),
     *             @OA\Property(
     *                 property="task_type_id",
     *                 type="string",
     *                 format="uuid",
     *                 description="Updated ID of the task type for the task"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input data"
     *     )
     * )
     *
     * Handle a request to update an existing task.
     *
     * @param UpdateRequest $request The incoming request.
     * @param Task $task The task to update.
     * @return JsonResponse The JSON response for the client.
     */
    public function update(UpdateRequest $request, Task $task): JsonResponse
    {
        $data = $request->validated();

        return $this->service->update($data, $task);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{task}",
     *     summary="Delete an existing task",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task to delete",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Task successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     *
     * Handle a request to delete an existing task.
     *
     * @param Task $task The task to delete.
     * @return JsonResponse The JSON response for the client.
     */
    public function delete(Task $task): JsonResponse
    {
        return $this->service->delete($task);
    }
}
