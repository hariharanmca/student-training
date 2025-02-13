<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class RoleMiddleware
{
   

        public function handle(Request $request, Closure $next, $role)
        {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
    
            if (!$request->user()->hasRole($role)) {
                return response()->json(['message' => 'Access denied. You do not have permission.'], 403);
            }
    
            return $next($request);
        }
    
}
