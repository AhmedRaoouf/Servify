<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function uploadImage(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->first();
        if ($request->image) {
            if ($user->image != null) {
                unlink('uploads/' . $user->image);
                $userImage = service::uploadImage($request->image, 'users/');
                $user->update(['image' => $userImage]);
            } else {
                $userImage = service::uploadImage($request->image, 'users/');
                $user->update(['image' => $userImage]);
            }
            return Service::responseData(['image'=> $userImage],'Image updated successfully');
        } else {
            return Service::responseError('Please provide an image.', '500');
        }
    }
}
