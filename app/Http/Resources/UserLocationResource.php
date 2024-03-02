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
            "country_id" => $this->country_id,
            "governorate_id" => $this->governorate_id,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ];
    }
}
