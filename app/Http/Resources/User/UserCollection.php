<?php

namespace App\Http\Resources\User;

use App\Traits\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class UserCollection
 */
class UserCollection extends ResourceCollection
{
    use PaginationResource;

    /**
     * Transform the resource into an array.
     *
     * This method iterates through the collection and maps each user resource
     * to an array with a specific structure. The key for each user resource
     * in the array is the index of the user in the collection.
     *
     * @param  Request  $request The current request instance.
     * @return array<string, mixed> The array representation of the user collection.
     */
    public function toArray(Request $request)
    {
        return $this->collection->mapWithKeys(
            function ($item, $key) {
                return [
                    $key => [
                        'id' => $item->id,
                        'name' => $item->name,
                        'email' => $item->email,
                        'role' => $item->role,
                    ],
                ];
            }
        );
    }
}
