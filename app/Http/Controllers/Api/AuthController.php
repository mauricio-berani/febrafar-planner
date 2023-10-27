<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;

/**
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
