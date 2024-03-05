<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordMail;
use App\Models\User;
use App\Models\UserAuthentication;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgetController extends Controller
{
    function forget(Request $request)
    {
        $vaildator = Validator::make($request->only('email'), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($vaildator->fails()) {
            return Service::responseError($vaildator->errors()->all(),422);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $otp = random_int(1000, 9999);
            $userAuth = UserAuthentication::where('user_id',$user->id)->first();
            $userAuth->update(['otp' => $otp,]);
            try {
                Mail::to($request->email)->send(new ForgetPasswordMail($userAuth->otp));
                return Service::responseMsg('OTP sent successfully');
            } catch (\Exception $e) {
                return Service::responseError($e->getMessage(),500);
            }
        }else{
            return Service::responseError("Email not found",404);
        }
    }

    function otp($otp)
    {
        $user = UserAuthentication::where('otp', $otp)->first();

        $response = [
            'status' => $user !== null,
        ];

        if (!$response['status']) {
            $response['message'] = 'OTP is not correct';
        }

        return response()->json($response);
    }

    public function reset(Request $request, $otp)
    {
        $validator = Validator::make($request->all(), [
            "password"  => ["required", "string", "min:8", "max:50", "confirmed"],
        ]);

        if ($validator->fails()) {
            return Service::responseError($validator->errors()->all(),422);
        }

        $userAuth = UserAuthentication::where('otp', $otp)->first();
        if (!$userAuth) {
            return response()->json(['message' => 'OTP is not correct'], 404);
        }
        $user = User::where('id',$userAuth->user_id)->first();

        if (Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'New password must be different from the previous password'], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        $userAuth->update(['otp'=>null]);

        return response()->json(['message' => 'Password changed successfully']);
    }
}
