<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'report_date' => Carbon::parse($this->report_date)->format('d M Y'),
            'user' => $this->whenLoaded('user'),
            'category' => $this->whenLoaded('category'),
        ];
    }
}