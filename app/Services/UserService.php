<?php

namespace App\Services;

use App\Http\Resources\User\{UserResource, UserCollection, PaginationCollection};
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * The UserService class provides methods to handle user-related actions.
 */
class UserService
{
    /**
     * @var UserRepository The user repository instance.
     */
    protected $repository;

    /**
     * Create a new UserService instance.
     *
     * @param  UserRepository  $repository  The user repository instance.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Fetches users based on the provided search parameters, and paginates the result.
     *
     * @param  array  $data  The search parameters.
     * @return JsonResponse
     */
    public function findAllMatches(array $data): JsonResponse
    {
        $search   = $data['search'] ?? null;
        $perPage  = $data['perPage'] ?? 10;
        $orderBy  = $data['orderBy'] ?? 10;
        $response = $this->repository->findAllMatches($search, $perPage, $orderBy);

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new PaginationCollection($response),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Fetches all users.
     *
     * @return JsonResponse
     */
    public function findAll(): JsonResponse
    {
        $reponse = $this->repository->findAll();

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new UserCollection($reponse),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Fetches a single user based on the provided user.
     *
     * @param  User  $user  The loaded user.
     * @return JsonResponse
     */
    public function findOne(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new UserResource($user),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Creates a new user based on the provided data.
     *
     * @param  array  $data  The user data.
     * @return JsonResponse
     */
    public function create(array $data): JsonResponse
    {
        $response = $this->repository->create($data);

        if (!$response) {
            return response()->json([
                'error' => 'An error occurred while executing the request.'
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new UserResource($response),
        ])->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Updates a user based on the provided data and user.
     *
     * @param  array  $data  The new user data.
     * @param  User  $user  The user loaded.
     * @return JsonResponse
     */
    public function update(array $data, User $user): JsonResponse
    {
        $response = $this->repository->update($data, $user);

        if (!$response) {
            return response()->json([
                'error' => 'An error occurred while executing the request.'
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'The request was successfully executed.',
            'data'   => new UserResource($response),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Deletes a user.
     *
     * @param  User  $user  The user loaded.
     * @return JsonResponse
     */
    public function delete(User $user): JsonResponse
    {
        $response = $this->repository->delete($user);

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
