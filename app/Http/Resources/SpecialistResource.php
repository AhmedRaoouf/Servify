<?php

namespace App\Http\Resources;

use App\Models\Specialist;
use App\Models\SpecialistReview;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $reviews = SpecialistReview::where('specialist_id', $this->user_id)->get();
        return [
            'service_name' => $this->service->description() ? $this->service->description()->name : null,
            'specialist_info' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'image' => $this->user->image ? asset('uploads') . "/".$this->user->image : 'Not Found',
                'location' => new UserLocationResource($this->user->location),
                'status' => $this->user->is_specialist,
                'rating' => $this->average_rating,
                'description' => $this->description,
                'earnings' => $this->earning,
                'num_of_experience' => $this->num_of_experience,
                'num_of_customers' => $this->num_of_customers,
            ],
            'reviews' => RatingResource::collection($reviews)
        ];
    }
}
