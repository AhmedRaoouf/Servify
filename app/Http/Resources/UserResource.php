<?php

namespace App\Http\Resources;

use App\Models\Role;
use App\Models\Specialist;
use App\Models\UserAuthentication;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $location = UserLocation::where( 'user_id', $this->id )->first();
        $auth = UserAuthentication::where( 'user_id', $this->id )->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => Role::where('id', $this->role_id)->value('name'),
            'is_specialist' => $this->is_specialist,
            'image' => $this->image ? asset('uploads') . "/$this->image" : 'Not Found',
            'user_auth' => new UserAuthResource( $auth ),
            'user_location' => new UserLocationResource( $location ),
        ];
    }
}
