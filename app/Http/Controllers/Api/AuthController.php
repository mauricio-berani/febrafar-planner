<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="APIs related to user authentication"
 * )
 *
 * Class AuthController
 *
 * @package App\Http\Controllers\Api
 * @resource Authentication
 */
class AuthController extends Controller
{

    /**
     * @var AuthService Authentication service.
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param AuthService $service Authentication service.
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Handle a login request to the application",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Login credentials",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 description="User's email"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="User's password"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User successfully logged in",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="access_token",
     *                 type="string",
     *                 description="JWT access token"
     *             ),
     *             @OA\Property(
     *                 property="token_type",
     *                 type="string",
     *                 description="Token type (Bearer)"
     *             ),
     *             @OA\Property(
     *                 property="expires_in",
     *                 type="integer",
     *                 description="Token expiration time in seconds"
     *             )
     *         )
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
     * Handle a login request to the application.
     *
     * This method validates the login request using LoginRequest,
     * and uses the AuthService to authenticate the user.
     *
     * @param LoginRequest $request The login request.
     * @return JsonResponse A JSON response indicating a successful login or a failure message.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->service->login($data);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Handle a logout request to the application",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=200,
     *         description="User successfully logged out"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * Handle a logout request to the application.
     *
     * This method invokes the logout method on the AuthService
     * to terminate the user's session and return a response.
     *
     * @param Request $request The request instance.
     * @return JsonResponse A JSON response indicating a successful logout or a failure message.
     */
    public function logout(Request $request): JsonResponse
    {
        return $this->service->logout($request);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Handle a registration request to the application",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User registration data",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="User's name"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 description="User's email"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="User's password"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User successfully registered",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 ref="#/components/schemas/User",
     *                 description="Registered user data"
     *             ),
     *             @OA\Property(
     *                 property="access_token",
     *                 type="string",
     *                 description="JWT access token"
     *             ),
     *             @OA\Property(
     *                 property="token_type",
     *                 type="string",
     *                 description="Token type (Bearer)"
     *             ),
     *             @OA\Property(
     *                 property="expires_in",
     *                 type="integer",
     *                 description="Token expiration time in seconds"
     *             )
     *         )
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
     * Handle a registration request to the application.
     *
     * This method validates the registration request using RegisterRequest,
     * and uses the AuthService to register the user.
     *
     * @param RegisterRequest $request The registration request.
     * @return JsonResponse A JSON response with the user data and token or a validation error response.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->service->register($data);
    }
}
