<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? $guards = [null] : $guards;

        foreach ($guards as $guard) {

            #check guard is authenticated
            if(Auth::guard($guard)->check()){

                Auth::shouldUse($guard);
                return $next($request);
            }
        }


        #handle unathenticated session
        $this->unathenticated($guards);


        
    }


    protected function unathenticated(array $guards) {
        throw new AuthenticationException(
            'Unauthenticated', $guards, $this->redirectTo()
        );
    }

    protected function redirectTo()
    {
        #customer
        if (Route::is('customer.*')) {
            return route('customer.login');
        }
        #admin
        if (Route::is('admin.*')) {
            return route('admin.login');
        }

        return route('home');
    }
}
