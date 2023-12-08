<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$type): Response
    {
        $user = $request->user();
        if(!$user)
        {
            return response()->json(['error' => 'You have to Login'], 404);
        }
        if($user->type != $type){
            return response()->json(['error' => 'Unauthorized'], 403);
        }
         return $next($request);
    }
}
