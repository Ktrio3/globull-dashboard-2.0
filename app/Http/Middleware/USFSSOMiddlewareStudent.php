<?php

namespace App\Http\Middleware;

use Closure;
use phpCAS;
use App\User;
use App\Student;
use Illuminate\Support\Facades\Auth;

class USFSSOMiddlewareStudent
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
            phpCAS::logoutWithRedirectService('http://www.usf.edu/orientation/');
        }
        else if (Auth::check()) {
          //If not a student must be an admin
          //Note that this allows students hired to view old profile
          //$uid = phpCas::getAttribute('USFeduUnumber');

          //$user = Student::where('uid', $uid)->exists();
          
          if (!Student::where('netid', Auth::user()->netid)->exists()) {
           // user found
           return redirect()->route('admin.index');
          }

          //Student
          return $next($request);
        }
        else if (phpCAS::isAuthenticated()) {
          //Check if admin -- if so, redirect to admin side
          $user = User::where('netid', phpCAS::getUser())->first();

          //var_dump(phpCAS::getAttributes());die();

          if($user != null)
          {
            Auth::loginUsingId($user->id);
            return redirect()->route('admin.index');
          }

          //Check if this is an student in the database
          // Note that this is currently using netid. Netid should be backup.
          
          $uid = phpCas::getAttribute('USFeduUnumber');

          $user = Student::where('uid', $uid)->first();

          if($user == null)
          {
            // Switch to UID as primary later.
            $user = Student::where('netid', phpCAS::getUser())->first();
          }

          if($user != null)
          {
            Auth::login($user);
            return $next($request);
          }

          //Not student or admin. Prompt with message later
          return redirect()->route('user_not_found');
        }
        else {
            phpCAS::forceAuthentication();
        }
    }
}
