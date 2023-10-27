<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateRequest, UpdateRequest};
use App\Http\Requests\Common\MatchRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        $this->authorize(__FUNCTION__, User::class);
        $data = $request->validated();

        return $this->service->update($data, $user);
    }
}
