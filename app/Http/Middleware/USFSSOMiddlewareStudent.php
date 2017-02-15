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
            return $next($request);
        } else if (phpCAS::isAuthenticated()) {
            //Check if this is a student in the database
            // Note that this is currently using netid. This should be backup.
            // Switch to UID as primary later.
            $user = Student::where('netid', phpCAS::getUser())->first();

            //var_dump(phpCAS::getAttributes());die();

            if($user != null)
            {
              Auth::loginUsingId($user->id);
              return $next($request);
            }

            //Prompt with message later
            return redirect('http://www.usf.edu/orientation/');

        } else {
            phpCAS::forceAuthentication();
        }
    }
}
