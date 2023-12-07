<?php

namespace App\Http\Controllers\Api;

use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequet;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\ActiveMail;
use App\Mail\ForgetPasswordMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $imageName = helper::uploadFile($request->file('image'), 'users/');

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'image'    => $imageName,
            'role_id'  => Role::where('name', 'user')->value('id'),
        ]);

        return response()->json([
            "status"  => true,
            'message' => "You are successfully registered",
        ]);
    }

    public function login(LoginRequet $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = Str::random(64);
            $user->token = $token;
            $user->save();
            $cookie = cookie('auth_token', $token, 60 * 24 * 30);
            return response()->json([
                'status'  => true,
                'message' => 'Login successful',
                'user'    => new UserResource($user),
            ])->withCookie($cookie);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->first();
        if ($user) {
            $user->update(['token' => null]);
            Auth::logout();

            return response()->json([
                'status'  => true,
                'message' => 'Logged out successfully',
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Invalid token',
        ]);
    }

    function forget(Request $request)
    {
        $vaildator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($vaildator->fails()) {
            return response()->json([
                'errors' => $vaildator->errors()->all(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $otp = random_int(1000, 9999);
        $user->update([
            'otp' => $otp,
        ]);
        try {
            Mail::to($request->email)->send(new ForgetPasswordMail($user->otp));
            return response()->json([
                'message' => 'OTP sent successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    function otp($otp)
    {
        $user = User::where('otp', $otp)->first();

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
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $user = User::where('otp', $otp)->first();

        if (!$user) {
            return response()->json(['message' => 'OTP is not correct'], 404);
        }

        if (Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'New password must be different from the previous password'], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
        ]);

        return response()->json(['message' => 'Password changed successfully']);
    }


    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $user = User::where('email', $request->input('email'))->first();
        if (!$user->hasVerifiedEmail()) {
            $code = random_int(1000, 9999);

            $user->verification_code = $code;
            $user->save();

            try {
                Mail::to($request->email)->send(new ActiveMail($user->verification_code));
                return response()->json([
                    'message' => 'verification code sent successfully',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Verification Code sent successfully.',
            ]);
        }
    }


    public function verify($code)
{
    $user = User::where('verification_code', $code)->first();

    if (!$user) {
        return response()->json([
            'status'  => false,
            'message' => 'Verification code is not correct'
        ], 404);
    }

    if ($user->email_verified_at !== null) {
        return response()->json([
            'status'  => false,
            'message' => 'Email is already verified'
        ], 400);
    }

    $user->update([
        'verification_code' => null,
        'email_verified_at' => now(),
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Email activated successfully'
    ]);
}

}
