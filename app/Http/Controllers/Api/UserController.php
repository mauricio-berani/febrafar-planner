<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateRequest, UpdateRequest};
use App\Http\Requests\Common\MatchRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * Class UserController
 *
 * This controller handles incoming HTTP requests related to user management,
 * delegating the business logic to the UserService.
 *
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{

    /**
     * The user service instance.
     *
     * @var UserService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param UserService $service The user service instance.
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle a request to find all matching users based on certain criteria.
     *
     * @param MatchRequest $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function findAllMatches(MatchRequest $request): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);
        $data = $request->validated();

        return $this->service->findAllMatches($data);
    }

    /**
     * Handle a request to find all users.
     *
     * @return JsonResponse The JSON response for the client.
     */
    public function findAll(): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);

        return $this->service->findAll();
    }

    /**
     * Handle a request to find a single user.
     *
     * @param User $user The user to find.
     * @return JsonResponse The JSON response for the client.
     */
    public function findOne(User $user): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);

        return $this->service->findOne($user);
    }

    /**
     * Handle a request to create a new user.
     *
     * @param CreateRequest $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);
        $data = $request->validated();

        return $this->service->create($data);
    }

    /**
     * Handle a request to update an existing user.
     *
     * @param UpdateRequest $request The incoming request.
     * @param User $user The user to update.
     * @return JsonResponse The JSON response for the client.
     */
    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);
        $data = $request->validated();

        return $this->service->update($data, $user);
    }

    /**
     * Handle a request to delete an existing user.
     *
     * @param User $user The user to delete.
     * @return JsonResponse The JSON response for the client.
     */
    public function delete(User $user): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);

        return $this->service->delete($user);
    }
}
