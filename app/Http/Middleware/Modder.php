<?php

namespace App\Http\Middleware;

use Closure;
use phpCAS;
use App\User;
use Illuminate\Support\Facades\Auth;

class Modder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $user = Auth::user();

      if($user->role_id <= 2) //Modder role
      {
        return $next($request);
      }

      $route = $request->route()->getName();
      $routeparts = explode('.', $route);

      $resource = $routeparts[0];

      //$routePrefix = $route.

      //Prompt with message later
      return redirect()->route($resource . '.index')->with('error', 'Access denied.');
    }
}
