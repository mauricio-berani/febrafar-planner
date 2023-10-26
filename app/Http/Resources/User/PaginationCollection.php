<?php

namespace App\Http\Resources\User;

use App\Http\Resources\User\UserResource;
use App\Traits\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class PaginationCollection
 *
 * @package App\Http\Resources\User
 *
 * This class represents a paginated collection of user resources.
 */
class PaginationCollection extends ResourceCollection
{
    use PaginationResource;

    /**
     * Transform the resource into an array.
     *
     * This method merges the paginated user resources with pagination details.
     *
     * @param Request $request The current request instance.
     * @return array<string, mixed> The array representation of the paginated user resources.
     */
    public function toArray(Request $request)
    {
        return array_merge(
            ['items' => UserResource::collection($this->collection)->resource],
            $this->paginationDetails()
        );
    }
}
