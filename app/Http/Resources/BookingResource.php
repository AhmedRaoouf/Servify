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
        $user = User::where('user_id',$this->user_id)->first();
        $specialist = Specialist::where('specialist_id',$this->specialist_id)->first();
        return [
            'id' => $this->id,
            'user' => new UserResource($user),
            'specialist' => new SpecialistResource($specialist),
            'description' => $this->description,
            'status' => $this->status,
            'booking_date' => $this->booking_date,
            'booking_time' => $this->booking_time,
        ];
    }
}
