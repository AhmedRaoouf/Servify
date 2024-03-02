<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "token" => $this->token,
            'provider' => $this->google_id ? 'Google' : ($this->facebook_id ? 'Facebook' : null),
            'email_active' => $this->email_verified_at ? 'Yes' : 'No',
            "verification_code"=> $this->verification_code,
            "verification_code_created_at"=> $this->verification_code_created_at ,
            "otp"=> $this->otp,
            "remember_token"=> $this->remember_token,
        ];
    }
}
