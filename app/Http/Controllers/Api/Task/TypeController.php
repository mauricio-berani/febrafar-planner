<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\Type\{CreateRequest, UpdateRequest};
use App\Http\Requests\Common\MatchRequest;
use App\Models\Task\Type;
use App\Services\Task\TypeService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Task Types",
 *     description="APIs related to task type management"
 * )
 */

/**
 * @OA\Schema(
 *     schema="TaskType",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="Task Type ID"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Task Type name"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Task Type status"
 *     )
 * )
 *
 * Class TypeController
 *
 * This controller handles incoming HTTP requests related to task type management,
 * delegating the business logic to the TypeService.
 *
 * @package App\Http\Controllers\Api\Task
 */
class TypeController extends Controller
{

    /**
     * The task type service instance.
     *
     * @var TaskTypeService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param TaskTypeService $service The task type service instance.
     */
    public function __construct(TypeService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/task-types/matches",
     *     summary="Find all task types that match certain criteria",
     *     tags={"Task Types"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="Name to match",
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
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of matching task types successfully retrieved",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TaskType")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * Handle a request to find all matching task types based on certain criteria.
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
     *     path="/api/task-types",
     *     summary="Retrieve the list of task types",
     *     tags={"Task Types"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all task types successfully retrieved",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TaskType")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * Handle a request to find all task types.
     *
     * @return JsonResponse The JSON response for the client.
     */
    public function findAll(): JsonResponse
    {
        return $this->service->findAll();
    }

    /**
     * @OA\Get(
     *     path="/api/task-types/{type}",
     *     summary="Retrieve a single task type",
     *     tags={"Task Types"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         required=true,
     *         description="ID of the task type to retrieve",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task type successfully retrieved",
     *         @OA\JsonContent(ref="#/components/schemas/TaskType")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task type not found"
     *     )
     * )
     *
     * Handle a request to find a single task type.
     *
     * @param Type $type The task type to find.
     * @return JsonResponse The JSON response for the client.
     */
    public function findOne(Type $type): JsonResponse
    {
        return $this->service->findOne($type);
    }
    /**
     * @OA\Post(
     *     path="/api/task-types",
     *     summary="Create a new task type",
     *     tags={"Task Types"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Task type creation data",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Name of the new task type"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="Status of the new task type"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task type successfully created",
     *         @OA\JsonContent(ref="#/components/schemas/TaskType")
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
     * Handle a request to create a new task type.
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
     *     path="/api/task-types/{type}",
     *     summary="Update an existing task type",
     *     tags={"Task Types"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         required=true,
     *         description="ID of the task type to update",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated task type data",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Updated name of the task type"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="Updated status of the task type"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task type successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/TaskType")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task type not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input data"
     *     )
     * )
     *
     * Handle a request to update an existing task type.
     *
     * @param UpdateRequest $request The incoming request.
     * @param Type $type The task type to update.
     * @return JsonResponse The JSON response for the client.
     */
    public function update(UpdateRequest $request, Type $type): JsonResponse
    {
        $data = $request->validated();

        return $this->service->update($data, $type);
    }

    /**
     * @OA\Delete(
     *     path="/api/task-types/{type}",
     *     summary="Delete an existing task type",
     *     tags={"Task Types"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         required=true,
     *         description="ID of the task type to delete",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Task type successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task type not found"
     *     )
     * )
     *
     * Handle a request to delete an existing task type.
     *
     * @param Type $type The task type to delete.
     * @return JsonResponse The JSON response for the client.
     */
    public function delete(Type $type): JsonResponse
    {
        return $this->service->delete($type);
    }
}
