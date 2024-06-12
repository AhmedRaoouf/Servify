<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAuthentication;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function uploadImage(Request $request)
    {
        $user = UserAuthentication::where('token', $request->header('Authorization'))->first()->user;
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,webp',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        if ($user->image != null) {
            unlink('uploads/' . $user->image);
        }
        $userImage = service::uploadImage($request->file('image'), 'users/');
        $user->update(['image' => $userImage]);
        return Service::responseData(['image' => asset("uploads/$userImage")], 'Image updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $user = UserAuthentication::where('token', $request->header('Authorization'))->first()->user;
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'string', 'min:8', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'max:50', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return Service::responseError($validator->errors(), 422);
        }
        if (Hash::check($request->old_password, $user->password)) {
            if (!Hash::check($request->password, $user->password)) {
                $user->update(['password' => $request->password]);
                return Service::responseMsg("Your password updated successfully");
            } else {
                return Service::responseMsg("New password must be different from the previous password");
            }
        } else {
            return  Service::responseError("The old password is incorrect.", 401);
        }
    }

    public function showUserData(User $user)
    {
        return Service::responseData( [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->image ? asset('uploads') . "/$user->image" : 'Not Found',
        ],'user data');
    }

}
