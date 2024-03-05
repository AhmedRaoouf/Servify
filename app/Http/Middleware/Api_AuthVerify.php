<?php

namespace App\Http\Middleware;

use App\Models\UserAuthentication;
use App\Services\Service;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Api_AuthVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token =$request->header('Authorization');
        $user = UserAuthentication::where('token',$token)->first();
        if ($user->email_verified_at) {
            return $next($request);
        }else{
            return Service::responseError("Must Verify Email",403);
        }
    }
}
