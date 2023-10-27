<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateRequest, UpdateRequest};
use App\Http\Requests\Common\MatchRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class FindAllController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function findAll(): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);

        return $this->service->findAll();
    }
}
