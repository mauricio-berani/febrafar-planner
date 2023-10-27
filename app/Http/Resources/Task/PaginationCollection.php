<?php

namespace App\Http\Resources\Task;

use App\Traits\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class PaginationCollection
 */
class PaginationCollection extends ResourceCollection
{
    use PaginationResource;

    /**
     * Transform the resource into an array.
     *
     * This method merges the paginated task resources with pagination details.
     *
     * @param  Request  $request The current request instance.
     * @return array<string, mixed> The array representation of the paginated task resources.
     */
    public function toArray(Request $request)
    {
        return array_merge(
            ['items' => TaskResource::collection($this->collection)->resource],
            $this->paginationDetails()
        );
    }
}
