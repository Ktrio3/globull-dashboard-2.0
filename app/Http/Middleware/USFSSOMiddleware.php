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
            $user = User::firstOrCreate(['netid' => phpCAS::getUser()]);
            if(!$user->role)
            {
              $user->created_by = 1;
              $user->updated_by = 1;
              $user->role = 2; //role 2 is proposer
              $user->save();
            }

            Auth::loginUsingId($user->id);

            return $next($request);
        } else {
            phpCAS::forceAuthentication();
        }
    }
}
