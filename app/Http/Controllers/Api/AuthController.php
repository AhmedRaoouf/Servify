<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequet;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\ActiveMail;
use App\Models\Role;
use App\Models\User;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $imageName = service::uploadImage($request->image, 'users/');

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => $request->password,
            'image'    => $imageName,
            'role_id'  => Role::where('name', 'user')->value('id'),
        ]);

        $code = random_int(1000, 9999);
        $user->update([
            'verification_code' => $code,
            'verification_code_created_at' => now(),
        ]);
        Mail::to($request->email)->send(new ActiveMail($user->verification_code));
        return service::responseMsg("You are successfully registered");
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
            return service::responseData(new UserResource($user), 'Login successful')->withCookie($cookie);
        }
        return service::responseError('Invalid credentials', 401);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->first();
        if ($user) {
            $user->update(['token' => null]);
            Auth::logout();
            return service::responseMsg('Logged out successfully');
        }
        return service::responseError('Invalid token', 404);
    }

    public function handleGoogleLogin(Request $request, string $uid)
    {
        try {
            $firebase = Firebase::auth();
            $userData = $firebase->getUser($uid);
            $user = User::where('email', $userData->email)->first();
            $access_token = Str::random(64);
            if ($user != null) {
                $user->update(['token' => $access_token]);
                Auth::login($user);
                return service::responseData(new UserResource($user), 'Login successful');
            } else {
                // Perform user registration
                $access_token = Str::random(64);
                $newuser = new User();
                $newuser->name = $userData->displayName;
                $newuser->email = $userData->email;
                $newuser->google_id = $userData->providerData[0]->uid;
                $newuser->email_verified_at = now();
                $newuser->password = $userData->uid . now();
                $newuser->token = $access_token;
                $newuser->role_id = Role::where('name', 'user')->value('id');
                $newuser->save();
                return service::responseData(new UserResource($user), 'You are successfully registered');
            }
        } catch (UserNotFound $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function handleFacebookLogin(Request $request, string $uid)
    {
        try {
            $firebase = Firebase::auth();
            $userData = $firebase->getUser($uid);
            $user = User::where('email', $userData->email)->first();
            $access_token = Str::random(64);
            if ($user != null) {
                $user->update(['token' => $access_token]);
                Auth::login($user);
                return service::responseData(new UserResource($user), 'Login successful');
            } else {
                // Perform user registration
                $access_token = Str::random(64);
                $newuser = new User();
                $newuser->name = $userData->displayName;
                $newuser->email = $userData->email;
                $newuser->facebook_id = $userData->providerData[0]->uid;
                $newuser->email_verified_at = now();
                $newuser->password =$userData->uid . now(); // You might want to improve how you generate passwords
                $newuser->token = $access_token;
                $newuser->role_id = Role::where('name', 'user')->value('id');
                $newuser->save();
                return service::responseData(new UserResource($newuser), 'You are successfully registered');
            }
        } catch (UserNotFound $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
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

            $user->update([
                'verification_code' => $code,
                'verification_code_created_at' => now(),
            ]);

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
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Email is already verified'
            ], 400);
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
        // Check if the verification code is still valid (within 3 minutes)
        if (now()->diffInMinutes($user->verification_code_created_at) > 3) {
            $user->update([
                'verification_code' => null,
                'verification_code_created_at' => null,
            ]);
            return service::responseError('Verification code has expired',422);
        }

        $user->update([
            'verification_code' => null,
            'verification_code_created_at' => null,
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Email activated successfully'
        ]);
    }
}
