<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin extends Middleware
{

    private const ADMIN_TWITCH_ID = [
        450998053
    ];

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

        // get user obj (can't be null).
        $userLog = Auth::user();

        // verify id admin (TODO: use a table role).
        if(!in_array($userLog->twitch_id, AuthAdmin::ADMIN_TWITCH_ID)){
            return redirect()->back()->with('error', 'vous devez être Admin !');
        }

        return $next($request);
    }
}
