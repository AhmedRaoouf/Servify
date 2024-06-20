<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Http\Requests\LoginRequet;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\ActiveMail;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAuthentication;
use App\Models\UserLocation;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $userLocation = UserLocation::create([
            'user_id' => $user->id,
            'country_id' => $request->country_id,
            'governorate_id' => $request->governorate_id,
            'latitude'    => $request->latitude,
            'longitude'    => $request->longitude,

        ]);
        $code = random_int(1000, 9999);
        $userAuth = UserAuthentication::create([
            'user_id' => $user->id,
            'verification_code' => $code,
            'verification_code_created_at' => now(),
        ]);

        Mail::to($request->email)->send(new ActiveMail($userAuth->verification_code));
        return service::responseData(new UserResource($user), "You are successfully registered");
    }

    public function login(LoginRequet $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = Str::random(64);

            $userAuth = UserAuthentication::where('user_id', $user->id)->first();
            $userAuth->token = $token;
            $userAuth->save();

            $cookie = cookie('auth_token', $token, 60 * 24 * 30);
            return service::responseData(new UserResource($user), 'Login successful')->withCookie($cookie);
        }
        return service::responseError('Invalid credentials', 401);
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        $userAuth  = UserAuthentication::where('token', $token)->first();
        if ($userAuth) {
            $userAuth->update(['token' => null]);
            Auth::logout();
            return service::responseMsg('Logged out successfully');
        }
        return service::responseError('Invalid token', 404);
    }


    public function handleSocialLogin(Request $request, string $provider, string $uid)
    {
        try {
            $firebase = Firebase::auth();
            $userData = $firebase->getUser($uid);
            if ($userData === null) {
                throw new UserNotFound('User not found.');
            }

            $user = User::where('email', $userData->email)->first();
            $token = Str::random(64);

            if ($user !== null) {
                $userAuth = UserAuthentication::where('user_id', $user->id)->first();
                $userAuth->token = $token;
                $userAuth->save();
                Auth::login($user);
                return service::responseData(new UserResource($user), 'Login successful');
            } else {
                $newuser = User::create([
                    'name' => $userData->displayName,
                    'email' => $userData->email,
                    'password' => $userData->uid . now(),
                    'role_id' => Role::where('name', 'user')->value('id'),
                ]);
                UserLocation::create([
                    'user_id'   => $newuser->id,
                    'country_id' => $request->country_id,
                    'governorate_id' => $request->governorate_id,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                ]);
                $userAuthData = [
                    'user_id'   => $newuser->id,
                    'token'  => $token,
                    'email_verified_at' => now(),
                ];

                if ($provider === 'google') {
                    $userAuthData['google_id'] = optional($userData->providerData[0])->uid;
                } elseif ($provider === 'facebook') {
                    $userAuthData['facebook_id'] = optional($userData->providerData[0])->uid;
                }

                $userAuth = UserAuthentication::create($userAuthData);
                return service::responseData(new UserResource($newuser), 'You are successfully registered');
            }
        } catch (UserNotFound $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
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
        $userAuth = UserAuthentication::where('user_id', $user->id)->first();
        if (!$userAuth->email_verified_at) {
            $code = random_int(1000, 9999);

            $userAuth->update([
                'verification_code' => $code,
                'verification_code_created_at' => now(),
            ]);

            try {
                Mail::to($request->email)->send(new ActiveMail($userAuth->verification_code));
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
        $userAuth = UserAuthentication::where('verification_code', $code)->first();
        if (!$userAuth) {
            return response()->json([
                'status'  => false,
                'message' => 'Verification code is not correct'
            ], 404);
        }
        if (now()->diffInMinutes($userAuth->verification_code_created_at) > 3) {
            $userAuth->update([
                'verification_code' => null,
                'verification_code_created_at' => null,
            ]);
            return service::responseError('Verification code has expired', 422);
        }

        $userAuth->update([
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
