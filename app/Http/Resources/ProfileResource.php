<?php

namespace App\Http\Resources;

use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $location = UserLocation::where('user_id', $this->id)->first();
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'image' => $this->image ? asset('uploads') . "/$this->image" : 'Not Found',
            "country" => $location->country->description()->name ?? null,
            "governorate" => $location->governorate->description()->name ?? null,
        ];
    }
}
