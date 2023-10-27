<?php

namespace App\Http\Resources\Task;

use App\Traits\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class TaskCollection
 */
class TaskCollection extends ResourceCollection
{
    use PaginationResource;

    /**
     * Transform the resource into an array.
     *
     * This method iterates through the collection and maps each task resource
     * to an array with a specific structure. The key for each task resource
     * in the array is the index of the task in the collection.
     *
     * @param  Request  $request The current request instance.
     * @return array<string, mixed> The array representation of the task collection.
     */
    public function toArray(Request $request)
    {
        return $this->collection->mapWithKeys(
            function ($item, $key) {
                return [
                    $key => [
                        'id' => $item->id,
                        'title' => $item->title,
                        'status' => $item->status,
                        'description' => $item->description,
                        'start_date' => $item->start_date,
                        'deadline' => $item->deadline,
                        'end_date' => $item->end_date,
                        'type' => $item->type->name,
                        'owner' => $item->user->name,
                    ],
                ];
            }
        );
    }
}
