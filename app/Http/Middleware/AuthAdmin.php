<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
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
        $userLog = Auth::user();

        if(!isset($userLog)){
            return redirect()->back()->with('error', 'utilisateur non connecté !');
        }

        if(!in_array($userLog->twitch_id, AuthAdmin::ADMIN_TWITCH_ID)){
            return redirect()->back()->with('error', 'vous devez être Admin !');
        }

        return $next($request);
    }
}
