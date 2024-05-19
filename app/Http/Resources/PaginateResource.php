<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    private $dataResource;
    public function __construct($resource, $dataResource)
    {
        parent::__construct($resource);
        $this->dataResource = $dataResource;
    }

    public function toArray($request)
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->dataResource,
            'total' => $this->total(),
            'last_page' => $this->lastPage(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'links' => $this->linkCollection()

        ];
    }
}
