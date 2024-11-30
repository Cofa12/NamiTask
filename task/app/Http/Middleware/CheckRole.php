<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $role): Response
    {
        if($role=='admin'){
            if (!Auth()->guard('admin')->check()){
                return response()->json([
                    'Message'=>"You are not authorized admin to do this action"
                ]);
            }
        }else if ($role=='user'){
            if (!Auth()->check()){
                return response()->json([
                    'Message'=>"You are not authorized user to do this action"
                ]);
            }
        }

        return $next($request);
    }
}
