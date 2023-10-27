<?php

namespace App\Http\Resources\Task\Type;

use App\Http\Resources\Task\Type\TypeResource;
use App\Traits\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class PaginationCollection
 *
 * @package App\Http\Resources\Task\Type
 *
 * This class represents a paginated collection of task types resources.
 */
class PaginationCollection extends ResourceCollection
{
    use PaginationResource;

    /**
     * Transform the resource into an array.
     *
     * This method merges the paginated task types resources with pagination details.
     *
     * @param Request $request The current request instance.
     * @return array<string, mixed> The array representation of the paginated task types resources.
     */
    public function toArray(Request $request)
    {
        return array_merge(
            ['items' => TypeResource::collection($this->collection)->resource],
            $this->paginationDetails()
        );
    }
}
