<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 *
 * @package App\Services
 *
 * This service class handles the authentication related operations such as user registration,
 * login, token validation, and logout.
 */
class AuthService
{

    /**
     * @var UserRepository An instance of UserRepository to interact with the User data.
     */
    protected $repository;

    /**
     * AuthService constructor.
     *
     * @param UserRepository $repository An instance of UserRepository.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Register a new user.
     *
     * @param array $data The data required to create a new user.
     * @return JsonResponse The JSON response with a success message, user data, and API token,
     *                      or an error message if the user creation failed.
     */
    public function register(array $data): JsonResponse
    {
        $user = $this->repository->create($data);

        if (!$user) {
            return response()->json([
                'message' => 'Error creating user.',
            ])->setStatusCode(Response::HTTP_CREATED);
        }

        return response()->json([
            'message' => 'User created successfully.',
            'data'   => [
                'user' => new UserResource($user),
                'token' => $user->createToken('api_token')->plainTextToken
            ],
        ])->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Login an existing user.
     *
     * @param array $data The credentials required to authenticate a user.
     * @return JsonResponse The JSON response with a success message, user data, and API token,
     *                      or an error message if the credentials are incorrect.
     */
    public function login(array $data): JsonResponse
    {
        $user = $this->repository->getOneByEmail($data['email']);

        if (!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ])->serStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'Login successfully.',
            'data'   => [
                'user' => new UserResource($user),
                'token' => $user->createToken('api_token')->plainTextToken
            ],
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Logout the authenticated user.
     *
     * @param Request $request The current request instance.
     * @return JsonResponse The JSON response with a success message indicating that the logout was successful.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successfully.',
        ])->setStatusCode(Response::HTTP_OK);
    }
}
