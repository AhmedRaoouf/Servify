<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Services\Service;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token',$token)->first();
        if ($user) {
            return Service::responseData(new ProfileResource($user),'Profile');
        }else{
            return Service::responseError('User not found',404);
        }
    }

    public function update(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token',$token)->first();
        if ($request->name) {
            $user->update(['name' => $request->name]);
        }
        if ($request->email) {
            $user->update(['email' => $request->email]);
        }
        if ($request->phone) {
            $user->update(['phone' => $request->phone]);
        }
        if ($request->image) {
            if ($user->image != null) {
                unlink('uploads/' . $user->image);
                $userImage = service::uploadImage($request->image, 'users/');
                $user->update(['image' => $userImage]);
            } else {
                $userImage = service::uploadImage($request->image, 'users/');
                $user->update(['image' => $userImage]);
            }
        }
    }
}
