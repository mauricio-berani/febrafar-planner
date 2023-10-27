<?php

namespace App\Http\Resources\Task\Type;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TypeResource
 */
class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * This method is used to transform the task type data to a standard array
     * format that can be converted to JSON.
     *
     * @param  Request  $request The current request instance.
     * @return array<string, mixed> The array representation of the task type.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'status' => $this->resource->status,
        ];
    }
}
