<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\MatchRequest;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="User resource"
 * )
 */

/**
 * @OA\Schema(
 *     schema="User",
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="user id"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="user name"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="user email"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="user password"
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="string",
 *         description="user role"
 *     )
 * )
 *
 * Class UserController
 *
 * This controller handles incoming HTTP requests related to user management,
 * delegating the business logic to the UserService.
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
     * @OA\Get(
     *     path="/api/users/matches",
     *     summary="Find all users who match specific criteria",
     *     tags={"Users"},
     *
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="name to be founded",
     *
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of matching users retrieved successfully",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized"
     *     )
     * )
     *
     * Create a new controller instance.
     *
     * @param  UserService  $service The user service instance.
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle a request to find all matching users based on certain criteria.
     *
     * @param  MatchRequest  $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function findAllMatches(MatchRequest $request): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);
        $data = $request->validated();

        return $this->service->findAllMatches($data);
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Retrieve the list of users",
     *     tags={"Users"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of all users successfully retrieved",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized"
     *     )
     * )
     *
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
     * @OA\Get(
     *     path="/api/users/{user}",
     *     summary="Recover a single user",
     *     tags={"Users"},
     *
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="User ID to be retrieved",
     *
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="User recovered successfully",
     *
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     *
     * Handle a request to find a single user.
     *
     * @param  User  $user The user to find.
     * @return JsonResponse The JSON response for the client.
     */
    public function findOne(User $user): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);

        return $this->service->findOne($user);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="New user name"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 description="New user email"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="New user password"
     *             ),
     *             @OA\Property(
     *                 property="role",
     *                 type="string",
     *                 description="New user role"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input data"
     *     )
     * )
     *
     * Handle a request to create a new user.
     *
     * @param  CreateRequest  $request The incoming request.
     * @return JsonResponse The JSON response for the client.
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);
        $data = $request->validated();

        return $this->service->create($data);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{user}",
     *     summary="Update an existing user",
     *     tags={"Users"},
     *
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="User ID to be updated",
     *
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="New username"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 description="New user email"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="New user password"
     *             ),
     *             @OA\Property(
     *                 property="role",
     *                 type="string",
     *                 description="New user role"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados de entrada inválidos"
     *     )
     * )
     *
     * Handle a request to update an existing user.
     *
     * @param  UpdateRequest  $request The incoming request.
     * @param  User  $user The user to update.
     * @return JsonResponse The JSON response for the client.
     */
    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);
        $data = $request->validated();

        return $this->service->update($data, $user);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{user}",
     *     summary="Delete an existing user",
     *     tags={"Users"},
     *
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="User ID to be deleted",
     *
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="User deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     *
     * Handle a request to delete an existing user.
     *
     * @param  User  $user The user to delete.
     * @return JsonResponse The JSON response for the client.
     */
    public function delete(User $user): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);

        return $this->service->delete($user);
    }
}
