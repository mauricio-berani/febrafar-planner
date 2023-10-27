<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TaskResource
 *
 * @package App\Http\Resources\Task
 *
 * This class represents a JSON resource for a task.
 */
class TaskResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * This method is used to transform the task data to a standard array
     * format that can be converted to JSON.
     *
     * @param Request $request The current request instance.
     * @return array<string, mixed> The array representation of the task.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->resource->id,
            'title'        => $this->resource->title,
            'status'       => $this->resource->status,
            'description'  => $this->resource->description,
            'start_date'   => $this->resource->start_date,
            'deadline'     => $this->resource->deadline,
            'end_date'     => $this->resource->end_date,
            'type'         => $this->resource->type->name,
            'owner'        => $this->resource->user->name,
        ];
    }
}
