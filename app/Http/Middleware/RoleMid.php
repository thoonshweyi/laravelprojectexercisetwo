<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // for single role from route
    // public function handle(Request $request, Closure $next,$role): Response
    // {
    //     if(!Auth::check() || !Auth::user()->hasRole($role)){
    //             abort('403',"Unauthorized from role middleware");
    //     }
    //     return $next($request);
    // }

    // for multi role from route
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        if(!Auth::check() || !Auth::user()->hasRoles($roles)){
            abort('403',"Unauthorized from role middleware");
            // return redirect()->back()->with('error',"Unauthorized Role Access");
        }
        return $next($request);
    }


}
