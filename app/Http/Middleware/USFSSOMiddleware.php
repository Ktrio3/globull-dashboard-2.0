<?php

namespace App\Http\Middleware;

use Closure;
use phpCAS;
use App\User;
use Illuminate\Support\Facades\Auth;

class USFSSOMiddleware
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
        $cas_config = array(
            'host' => getenv('CAS_HOST'),
            'context' => getenv('CAS_CONTEXT'),
            'ca_cert_path' => getenv('CAS_CA_CERT_PATH'),
        );
        phpCAS::client(CAS_VERSION_2_0, $cas_config['host'], 443, $cas_config['context']);

        if ($cas_config['ca_cert_path'])
          phpCAS::setCasServerCACert($cas_config['ca_cert_path']); //set cert path
        else
          phpCAS::setNoCasServerValidation(); //turn off CAS server validation

        if ($request->has('logout')) {
            phpCAS::logout();
        } else if (Auth::check()) {
          //Redirect to student if this is a student logged in
          if (!User::where('netid', Auth::user()->netid)->exists()) {
           // not admin, must be student
           return redirect()->route('student.index');
          }

          return $next($request);
        } else if (phpCAS::isAuthenticated()) {
          //Check if the user is an admin
          $user = User::where('netid', phpCAS::getUser())->first();

          //var_dump(phpCAS::getAttributes());die();

          if($user != null)
          {
            Auth::loginUsingId($user->id);
            return $next($request);
          }

          return redirect('http://www.usf.edu/orientation/');
        } else {
            phpCAS::forceAuthentication();
        }
    }
}
