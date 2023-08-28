<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketDetailResource extends JsonResource
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
            'is_finished' => $this->is_finished,
            'attachment' => $this->attachment,
            'report_date' => Carbon::parse($this->report_date)->format('d M Y'),
            'user' => $this->user,
            'comment' => $this->whenLoaded('comment'),
            'category' => $this->whenLoaded('category'),
            'comments' => $this->whenLoaded('comments'),
        ];
    }
}