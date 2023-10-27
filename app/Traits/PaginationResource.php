<?php

namespace App\Traits;

trait PaginationResource
{
    /**
     * Get pagination details.
     *
     * @return array<string, mixed>
     */
    public function paginationDetails()
    {
        return [
            'first_page_url' => $this->resource->url(1),
            'from' => $this->resource->firstItem(),
            'last_page' => $this->resource->lastPage(),
            'last_page_url' => $this->resource->url($this->resource->lastPage()),
            'links' => $this->resource->links(),
            'next_page_url' => $this->resource->nextPageUrl(),
            'path' => $this->resource->resolveCurrentPath(),
            'per_page' => $this->resource->perPage(),
            'prev_page_url' => $this->resource->previousPageUrl(),
            'to' => $this->resource->lastItem(),
            'total' => $this->resource->total(),
            'current_page' => $this->resource->currentPage(),
        ];
    }
}
