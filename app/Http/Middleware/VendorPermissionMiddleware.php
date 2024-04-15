<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VendorPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)

    {
        
        // if (Auth::check()) {
            $user = Auth::user();
            // dd($user);
           
        if ($user && $user->type === "vendor"){
                return $next($request);
        }else{
            return response()->json(['error' => 'Permission not allowed'], 403);

        }
        
        // }
    }
}
