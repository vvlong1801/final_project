<?php

namespace App\Http\Resources\Collections\Traits;

trait PaginatesResourceCollection
{
    public function getPaginates()
    {
        return [
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->perPage() * ($this->currentPage() - 1) + 1,
                'to' => $this->perPage() * ($this->currentPage() - 1) + $this->count(),
                'last_page' => $this->lastPage(),
                'total' => $this->total(),
                'per_page' => $this->perPage(),

            ],
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'previous' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
        ];
    }
}
