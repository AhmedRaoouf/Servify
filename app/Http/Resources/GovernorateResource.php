<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GovernorateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'country' => new CountryResource($this),
            'governorates_en' => $this->governoratesDescription(1,$this->description()->country_id)->pluck('governorate_id','name')->toArray(),
            'governorates_ar' => $this->governoratesDescription(2,$this->description()->country_id)->pluck('governorate_id','name')->toArray(),
        ];
    }
}
