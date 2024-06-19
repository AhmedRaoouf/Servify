<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialistCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'service_name' => $this->service->description() ? $this->service->description()->name : null,
            'user_id' => $this->user->id,
            'specialist' => [
                'id' => $this->id,
                'name' => $this->user->name,
                'image' => $this->user->image ? asset('uploads') . "/".$this->user->image : 'Not Found',
                'status' => $this->user->is_specialist,
                'rating' => $this->average_rating,
                'description' => $this->description,
                'location' => new UserLocationResource($this->user->location),
            ],
        ];
    }
}
