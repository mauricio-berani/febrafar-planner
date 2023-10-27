<?php

namespace App\Services\Task;

use App\Http\Resources\Task\Type\PaginationCollection;
use App\Http\Resources\Task\Type\TypeCollection;
use App\Http\Resources\Task\Type\TypeResource;
use App\Models\Task\Type;
use App\Repositories\Task\TypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * The TypeService class provides methods to handle task type-related actions.
 */
class TypeService
{
    /**
     * @var TypeRepository The task type repository instance.
     */
    protected $repository;

    /**
     * Create a new TypeService instance.
     *
     * @param  TypeRepository  $repository  The task type repository instance.
     */
    public function __construct(TypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Fetches task types based on the provided search parameters, and paginates the result.
     *
     * @param  array  $data  The search parameters.
     */
    public function findAllMatches(array $data): JsonResponse
    {
        $search = $data['search'] ?? null;
        $perPage = $data['perPage'] ?? 10;
        $orderBy = $data['orderBy'] ?? 10;
        $response = $this->repository->findAllMatches($search, $perPage, $orderBy);

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data' => new PaginationCollection($response),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Fetches all task categories.
     */
    public function findAll(): JsonResponse
    {
        $reponse = $this->repository->findAll();

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data' => new TypeCollection($reponse),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Fetches a single task type based on the provided task type.
     *
     * @param  Type  $type  The loaded task type.
     */
    public function findOne(Type $type): JsonResponse
    {
        return response()->json([
            'message' => 'The request was successfully executed.',
            'data' => new TypeResource($type),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Creates a new task type based on the provided data.
     *
     * @param  array  $data  The task type data.
     */
    public function create(array $data): JsonResponse
    {
        $response = $this->repository->create($data);

        if (! $response) {
            return response()->json([
                'error' => 'An error occurred while executing the request.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data' => new TypeResource($response),
        ])->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Updates a task type based on the provided data and task type.
     *
     * @param  array  $data  The new task type data.
     * @param  Type  $type  The task type loaded.
     */
    public function update(array $data, Type $type): JsonResponse
    {
        $response = $this->repository->update($data, $type);

        if (! $response) {
            return response()->json([
                'error' => 'An error occurred while executing the request.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data' => new TypeResource($response),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Deletes a task type.
     *
     * @param  Type  $type  The task type loaded.
     */
    public function delete(Type $type): JsonResponse
    {
        $response = $this->repository->delete($type);

        if (! $response) {
            return response()->json([
                'error' => 'An error occurred while executing the request.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'The request was successfully executed.',
        ])->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
