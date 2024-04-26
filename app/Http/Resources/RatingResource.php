<?php

namespace App\Http\Resources;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
            'userReviewd' =>$this->user->name,
            'rating' => $this->rating,
            'review' => $this->review,
            'created_at' =>  Carbon::parse($this->created_at)->format('n/j/Y'),
        ];
    }
}
