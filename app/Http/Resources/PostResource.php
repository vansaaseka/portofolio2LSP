<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'is_finished' => $this->is_finished,
            'created_at' => $this->created_at->format('d M Y'),
            'user' => $this->whenLoaded('user'),
            'category' => $this->whenLoaded('category'),
            'topic' => $this->whenLoaded('topic'),
        ];
    }
}