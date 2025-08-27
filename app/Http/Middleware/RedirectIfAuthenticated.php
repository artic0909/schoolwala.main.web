<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guards = empty($guards) ? $guards = [null] : $guards;

        foreach ($guards as $guard) {
            #check guard is authenticated
            if (Auth::guard($guard)->check()) {

                #for customers
                if ($guard == 'customers' && Route::is('customer.*')) {
                    return redirect()->route('customer*');
                }
                #for admins
                elseif ($guard == 'admins' && Route::is('admin.*')) {
                    return redirect()->route('admin.dashboard');
                }
                
                else {
                    return redirect()->route('/');
                }
            }

            
            if ($guard == 'customers' && !Auth::guard('customers')->check()) {
                return redirect()->route('customer.login');
            }
        }

        return $next($request);
    }
}
