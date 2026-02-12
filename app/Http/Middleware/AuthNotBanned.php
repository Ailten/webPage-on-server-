<?php

namespace App\Http\Middleware;

use App\Utils\Role\RoleCheck;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthNotBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // json exception.
        if(!$request->expectsJson()){
            return redirect()->route('index')->with('error', 'erreur json expects !');
        }

        // if user not log.
        if(!Auth::check()){
            return redirect()->route('index')->with('error', 'utilisateur non connecté !');
        }

        // verify is banned.
        if(RoleCheck::isBanned(Auth::user())){
            return redirect()->route('index')->with('error', 'votre compte est temporairement blocké !');
        }

        return $next($request);
    }
}
