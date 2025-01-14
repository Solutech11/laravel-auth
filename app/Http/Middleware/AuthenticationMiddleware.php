<?php

namespace App\Http\Middleware;

use App\Models\AuthModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAuth= AuthModel::where("auth",  $request->header('Authorization'))->with('AuthUser')->first();
        
        if (!$userAuth)return response()->json([
            'Access' => false,
            'Error' => "User Logged out"
        ], 401);
        
        $request->attributes->set('user', $userAuth->AuthUser);

        return $next($request);
    }
}
