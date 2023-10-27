<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateRequest, UpdateRequest};
use App\Http\Requests\Common\MatchRequest;
use App\Models\Task\Type;
use App\Services\Task\TypeService;
use Illuminate\Http\JsonResponse;

/**
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
     * Handle a request to find all matching task types based on certain criteria.
     *
     * @param MatchRequest $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function findAllMatches(MatchRequest $request): JsonResponse
    {
        $this->authorize(__FUNCTION__, Type::class);
        $data = $request->validated();

        return $this->service->findAllMatches($data);
    }

    /**
     * Handle a request to find all task types.
     *
     * @return JsonResponse The JSON response for the client.
     */
    public function findAll(): JsonResponse
    {
        $this->authorize(__FUNCTION__, Type::class);

        return $this->service->findAll();
    }

    /**
     * Handle a request to find a single task type.
     *
     * @param Type $type The task type to find.
     * @return JsonResponse The JSON response for the client.
     */
    public function findOne(Type $type): JsonResponse
    {
        $this->authorize(__FUNCTION__, Type::class);

        return $this->service->findOne($type);
    }

    /**
     * Handle a request to create a new task type.
     *
     * @param CreateRequest $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $this->authorize(__FUNCTION__, TaskType::class);
        $data = $request->validated();

        return $this->service->create($data);
    }

    /**
     * Handle a request to update an existing task type.
     *
     * @param UpdateRequest $request The incoming request.
     * @param Type $type The task type to update.
     * @return JsonResponse The JSON response for the client.
     */
    public function update(UpdateRequest $request, Type $type): JsonResponse
    {
        $this->authorize(__FUNCTION__, Type::class);
        $data = $request->validated();

        return $this->service->update($data, $type);
    }

    /**
     * Handle a request to delete an existing task type.
     *
     * @param Type $type The task type to delete.
     * @return JsonResponse The JSON response for the client.
     */
    public function delete(Type $type): JsonResponse
    {
        $this->authorize(__FUNCTION__, Type::class);

        return $this->service->delete($type);
    }
}
