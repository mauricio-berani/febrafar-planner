<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

/**
 * Class LoginController
 *
 * @package App\Http\Controllers\Api\Auth
 * @resource Authentication
 */
class LoginController extends Controller
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
     * @return \Illuminate\Http\JsonResponse The token and user data, or a validation error response.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->service->login($data);
    }
}
