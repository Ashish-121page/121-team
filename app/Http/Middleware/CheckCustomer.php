<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (AuthRole() == 'Admin') {
            return redirect('/')->with('error',"You do not have permission to access customer dashboard");;
        }
        return $next($request);
    }
}
