<?php

namespace App\Http\Resources\Task\Type;

use App\Traits\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class TypeCollection
 */
class TypeCollection extends ResourceCollection
{
    use PaginationResource;

    /**
     * Transform the resource into an array.
     *
     * This method iterates through the collection and maps each task type resource
     * to an array with a specific structure. The key for each task type resource
     * in the array is the index of the task type in the collection.
     *
     * @param  Request  $request The current request instance.
     * @return array<string, mixed> The array representation of the task type collection.
     */
    public function toArray(Request $request)
    {
        return $this->collection->mapWithKeys(
            function ($item, $key) {
                return [
                    $key => [
                        'id' => $item->id,
                        'name' => $item->name,
                        'status' => $item->status,
                    ],
                ];
            }
        );
    }
}
