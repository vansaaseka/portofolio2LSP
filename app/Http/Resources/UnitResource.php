<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'category' => $this->whenLoaded('category'),
            'tickets' => $this->whenLoaded('tickets'),
            'posts' => $this->whenLoaded('posts'),
        ];
    }
}