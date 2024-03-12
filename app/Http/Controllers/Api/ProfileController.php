<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\UserAuthentication;
use App\Services\Service;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private function getUser(Request $request)
    {
        $token = $request->header('Authorization');
        $userAuth = UserAuthentication::where('token', $token)->first();
        return $userAuth->user;
    }

    public function show(Request $request)
    {
        $user = $this->getUser($request);
        if ($user) {
            return Service::responseData(new ProfileResource($user), 'Profile');
        } else {
            return Service::responseError('User not found', 404);
        }
    }

    public function update(Request $request)
    {
        $user = $this->getUser($request);
        if ($user) {
            if ($request->name) {
                $user->update(['name' => $request->name]);
            }
            if ($request->phone) {
                $user->update(['phone' => $request->phone]);
            }
        } else {
            return Service::responseError('User not found', 404);
        }
        return Service::responseData(new ProfileResource($user), 'Profile');
    }
}
