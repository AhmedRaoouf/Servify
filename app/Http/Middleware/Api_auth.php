<?php

namespace App\Http\Middleware;

use App\Models\UserAuthentication;
use App\Services\Service;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Api_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if ($token !== null) {
            $user = UserAuthentication::where('token', $token)->first();

            if ($user !== null) {
                return $next($request);
            }
        }

        Service::responseError("Unauthorized", 401);
    }
}
