<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "country" => $this->country->description()?->name,
            "governorate" => $this->governorate->description()?->name,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ];
    }
}
