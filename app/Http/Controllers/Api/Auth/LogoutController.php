<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

/**
 * Class LogoutController
 *
 * @package App\Http\Controllers\Api\Auth
 * @resource Authentication
 *
 * This controller handles the logout action for authenticated users.
 */
class LogoutController extends Controller
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
}
