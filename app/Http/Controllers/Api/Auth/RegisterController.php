<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

/**
 * Class RegisterController
 *
 * @package App\Http\Controllers\Api\Auth
 * @resource Authentication
 *
 * This controller handles the registration of new users.
 */
class RegisterController extends Controller
{

    /**
     * @var AuthService Authentication service instance.
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
