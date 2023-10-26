<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @package App\Http\Resources\User
 *
 * This class represents a JSON resource for a user.
 */
class UserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * This method is used to transform the user data to a standard array
     * format that can be converted to JSON.
     *
     * @param Request $request The current request instance.
     * @return array<string, mixed> The array representation of the user.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->resource->id,
            'name'  => $this->resource->name,
            'email' => $this->resource->email,
            'role'  => $this->resource->role,
        ];
    }
}
