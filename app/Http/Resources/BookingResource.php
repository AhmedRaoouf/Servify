<?php

namespace App\Http\Resources;

use App\Models\Specialist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $specialist = Specialist::where('id',$this->specialist_id)->first();
        return [
            'id' => $this->id,
            'user_id' => $specialist->user->id,
            'description' => $this->description,
            'status' => $this->status,
            'booking_date' => $this->booking_date,
            'booking_time' => $this->booking_time,
            'specialist' => new SpecialistCardResource($specialist),
        ];
    }
}
