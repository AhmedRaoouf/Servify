<?php

namespace App\Http\Resources;

use App\Models\Role;
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
            // 'token' => $this->token,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birthday' => $this->birthday,
            'role' => Role::where('id', $this->role_id)->value('name'),
            'image' => $this->image ? asset('uploads') . "/$this->image" : 'Not Found',
            'user_auth' => new UserAuthResource( $auth ),
            'user_location' => new UserLocationResource( $location ),
        ];
    }
}
