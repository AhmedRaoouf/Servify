<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $role = Auth::user()->role_id;
            if (in_array($role, [1, 2])) {
                return $next($request);
            } else {
                Auth::logout();
                session()->flash('error-msg', 'credentials not correct');
                return redirect()->route('admin.login');
            }
        }

        return redirect()->route('admin.login');
    }
}
