<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateRequest, UpdateRequest};
use App\Http\Requests\Common\MatchRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class CreateController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function create(CreateRequest $request): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);
        $data = $request->validated();

        return $this->service->create($data);
    }
}