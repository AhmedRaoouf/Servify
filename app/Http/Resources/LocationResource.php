<?php

namespace App\Http\Resources;

use App\Models\GovernorateDescription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'country' => $this->description()->pluck('country_id','name')->toArray(),
            'governorate' => $this->governorateDescriptions()->pluck('governorate_id','name')->toArray()
        ];

    }
}
