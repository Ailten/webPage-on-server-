<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Utils\Admin\AdminCheck;

class AuthAdmin extends Middleware
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

        // verify is admin.
        if(!AdminCheck::isAdmin(Auth::user())){
            return redirect()->back()->with('error', 'vous devez être Admin !');
        }

        return $next($request);
    }
}
