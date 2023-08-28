<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'body' => $this->body,
            'attachment' => $this->attachment,
            'is_finished' => $this->is_finished,
            'created_at' => $this->created_at->diffForHumans(),
            'user' => $this->whenLoaded('user'),
            'category' => $this->whenLoaded('category'),
            'topic' => $this->whenLoaded('topic'),
            'comments' => $this->whenLoaded('comments'),
        ];
    }
}